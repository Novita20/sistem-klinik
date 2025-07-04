<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\ResepObat;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResepObatController extends Controller
{
    // ✅ Paramedis: Menampilkan semua resep obat (dengan search & pagination)
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

    // ✅ Paramedis: Form tambah resep obat
    public function create()
    {
        $rekamMedis = RekamMedis::with('kunjungan.user')->get();
        $obats = Obat::all();

        return view('paramedis.resep.create', compact('rekamMedis', 'obats'));
    }

    // ✅ Paramedis: Simpan resep baru
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

        // Cek stok
        if ($request->jumlah > $obat->stok) {
            return back()->withErrors(['jumlah' => 'Jumlah melebihi stok obat']);
        }

        // Kurangi stok
        $obat->stok -= $request->jumlah;
        $obat->save();

        // Ambil rekam medis & pasien
        $rekamMedis = RekamMedis::with('kunjungan.user.pasien')->findOrFail($request->rekam_medis_id);
        $pasien = optional(optional($rekamMedis->kunjungan)->user)->pasien;

        if (!$pasien) {
            return back()->withErrors(['rekam_medis_id' => 'Data pasien tidak ditemukan']);
        }

        // Simpan resep
        ResepObat::create([
            'rekam_medis_id' => $request->rekam_medis_id,
            'obat_id'        => $request->obat_id,
            'jumlah'         => $request->jumlah,
            'dosis'          => $request->dosis,
            'aturan_pakai'   => $request->aturan_pakai,
            'keterangan'     => $request->keterangan,
            'pasien_id'      => $pasien->id,
        ]);

        // Ubah status kunjungan menjadi selesai
        optional($rekamMedis->kunjungan)->update(['status' => 'selesai']);

        return redirect()->route('paramedis.resep.index')->with('success', 'Resep berhasil disimpan.');
    }

    // ✅ Edit resep
    public function edit($id)
    {
        $resep = ResepObat::findOrFail($id);
        $obats = Obat::all();
        $rekamMedis = RekamMedis::with('kunjungan.user')->get();

        return view('paramedis.resep.edit', compact('resep', 'obats', 'rekamMedis'));
    }

    // ✅ Update resep
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

    // ✅ Hapus resep
    public function destroy($id)
    {
        $resep = ResepObat::findOrFail($id);
        $resep->delete();

        return redirect()->route('paramedis.resep.destroy')->with('success', 'Resep berhasil dihapus.');
    }

    // 👤 Pasien: Menampilkan resep miliknya
    public function indexResep()
    {
        $user = Auth::user();
        $pasien = Pasien::where('user_id', $user->id)->first();

        if ($pasien) {
            $resepObat = ResepObat::where('pasien_id', $pasien->id)
                ->with('obat', 'rekamMedis.kunjungan')
                ->latest()
                ->get();
        } else {
            $resepObat = collect();
        }

        return view('pasien.resep', compact('resepObat'));
    }
}
