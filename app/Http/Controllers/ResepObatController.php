<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\ResepObat;
use App\Models\LogObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResepObatController extends Controller
{
    // Menampilkan semua resep obat
    public function index(Request $request)
    {
        $query = ResepObat::with([
            'rekamMedis.kunjungan',
            'pasien.user',
            'obat',
            'logObat',
        ]);

        if ($request->filled('search')) {
            $query->whereHas('obat', function ($q) use ($request) {
                $q->where('nama_obat', 'like', '%' . $request->search . '%');
            });
        }

        $resepObat = $query->latest()->paginate(10);

        return view('paramedis.resep.index', compact('resepObat'));
    }

    // Form tambah resep
    public function create()
    {
        $rekamMedis = RekamMedis::with('kunjungan.user')->get();
        $obats = Obat::all();

        return view('paramedis.resep.create', compact('rekamMedis', 'obats'));
    }

    // Simpan resep baru & catat mutasi
    public function store(Request $request)
    {
        $request->validate([
            'rekam_medis_id' => 'required|exists:rekam_medis,id',
            'obat_id'        => 'required|exists:obat,id',
            'jumlah'         => 'required|integer|min:1',
            'dosis'          => 'nullable|string',
            'aturan_pakai'   => 'nullable|string',
            'keterangan'     => 'nullable|string',
        ]);

        $obat = Obat::findOrFail($request->obat_id);

        if ($request->jumlah > $obat->stok) {
            return back()->withErrors(['jumlah' => 'Jumlah melebihi stok obat']);
        }



        $rekamMedis = RekamMedis::with('kunjungan.user.pasien')->findOrFail($request->rekam_medis_id);
        $pasien = optional(optional($rekamMedis->kunjungan)->user)->pasien;

        if (!$pasien) {
            return back()->withErrors(['rekam_medis_id' => 'Data pasien tidak ditemukan']);
        }

        $resep = ResepObat::create([
            'rekam_medis_id' => $request->rekam_medis_id,
            'obat_id'        => $request->obat_id,
            'jumlah'         => $request->jumlah,
            'dosis'          => $request->dosis,
            'aturan_pakai'   => $request->aturan_pakai,
            'keterangan'     => $request->keterangan,
            'pasien_id'      => $pasien->id,
            'status_diberikan' => false,
        ]);

        // ✅ Kurangi stok obat
        $stokAwal = $obat->stok;
        $obat->stok -= $request->jumlah;
        $obat->save();

        LogObat::create([
            'obat_id'       => $obat->id,
            'jenis_mutasi'  => 'keluar',
            'jumlah'        => $request->jumlah,
            'stok_awal'     => $stokAwal,
            'sisa_stok'     => $obat->stok,
            'tgl_transaksi' => now(),
            'keterangan'    => 'Pemberian obat ke pasien oleh paramedis',
            'ref_type'      => 'resep',
            'ref_id'        => $resep->id,
        ]);

        optional($rekamMedis->kunjungan)->update(['status' => 'selesai']);

        return redirect()->route('paramedis.resep.index')->with('success', 'Resep berhasil disimpan & dicatat.');
    }

    // Edit resep
    public function edit($id)
    {
        $resep = ResepObat::findOrFail($id);
        $obats = Obat::all();
        $rekamMedis = RekamMedis::with('kunjungan.user')->get();

        return view('paramedis.resep.edit', compact('resep', 'obats', 'rekamMedis'));
    }

    // Update resep
    public function update(Request $request, $id)
    {
        $request->validate([
            'obat_id'      => 'required|exists:obat,id',
            'jumlah'       => 'required|integer|min:1',
            'dosis'        => 'nullable|string',
            'aturan_pakai' => 'nullable|string',
        ]);

        $resep = ResepObat::findOrFail($id);
        $resep->update([
            'obat_id'      => $request->obat_id,
            'jumlah'       => $request->jumlah,
            'dosis'        => $request->dosis,
            'aturan_pakai' => $request->aturan_pakai,
        ]);

        return redirect()->route('paramedis.resep.index')->with('success', 'Resep berhasil diperbarui.');
    }

    // Hapus resep
    public function destroy($id)
    {
        $resep = ResepObat::findOrFail($id);
        $resep->delete();

        return redirect()->route('paramedis.resep.index')->with('success', 'Resep berhasil dihapus.');
    }

    // Pasien: Lihat resep miliknya
    public function indexResep()
    {
        $user = Auth::user();
        $pasien = Pasien::where('user_id', $user->id)->first();

        $resepObat = $pasien
            ? ResepObat::where('pasien_id', $pasien->id)->with('obat', 'rekamMedis.kunjungan')->latest()->get()
            : collect();

        return view('pasien.resep', compact('resepObat'));
    }

    // Opsional: Kalau mau pisahkan aksi "berikan obat" dari create
    public function berikanObat($id)
    {
        // Ambil data resep dan relasi obat
        $resep = ResepObat::with('obat')->findOrFail($id);

        // Cegah jika obat sudah diberikan sebelumnya
        if ($resep->status_diberikan) {
            return redirect()->back()->with('warning', 'Obat sudah diberikan sebelumnya.');
        }

        // Ambil data obat terkait
        $obat = $resep->obat;

        // Cek apakah stok cukup
        if (!$obat || $obat->stok < $resep->jumlah) {
            return redirect()->back()->with('error', 'Stok obat tidak mencukupi atau data obat tidak ditemukan.');
        }

        // ✅ Simpan stok awal SEBELUM dikurangi
        $stokAwal = $obat->stok;

        // Kurangi stok
        $obat->stok -= $resep->jumlah;
        $obat->save();

        // Update status resep menjadi "sudah diberikan"
        $resep->update(['status_diberikan' => true]);

        // ✅ Catat mutasi di log_obat
        LogObat::create([
            'obat_id'      => $obat->id,
            'jenis_mutasi' => 'keluar',
            'jumlah'       => $resep->jumlah,
            'stok_awal'    => $stokAwal,       // Nilai sebelum dikurangi
            'sisa_stok'    => $obat->stok,     // Nilai setelah dikurangi
            'tgl_transaksi' => now(),
            // 'expired_at'   => $obat->expired_at,
            'keterangan'   => 'Obat diberikan ke pasien (melalui aksi Berikan)',
            'ref_type'     => 'resep',
            'ref_id'       => $resep->id,
        ]);

        return redirect()->route('paramedis.resep.index')->with('success', 'Obat berhasil diberikan & dicatat.');
    }
}
