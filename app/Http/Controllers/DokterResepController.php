<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\ResepObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DokterResepController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $reseps = ResepObat::with(['obat', 'rekamMedis.kunjungan.pasien.user'])
            ->where(function ($query) use ($search) {
                $query->whereHas('rekamMedis.kunjungan.pasien.user', function ($q) use ($search) {
                    if ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    }
                });

                $query->orWhereHas('obat', function ($q) use ($search) {
                    if ($search) {
                        $q->where('nama_obat', 'like', '%' . $search . '%');
                    }
                });
            })
            ->orderByDesc('created_at')
            ->paginate(10); // Ubah jumlah per halaman sesuai kebutuhan

        return view('dokter.resep.index', compact('reseps', 'search'));
    }

    // 🧾 Form input resep oleh dokter
    public function create($rekam_medis_id)
    {
        $rekamMedis = RekamMedis::with('kunjungan.pasien.user')->findOrFail($rekam_medis_id);
        $obats = Obat::all();

        return view('dokter.resep.create', compact('rekamMedis', 'obats'));
    }

    // 💾 Simpan resep baru oleh dokter
    public function store(Request $request)
    {
        Log::info('Memulai store resep', $request->all());

        $request->validate([
            'rekam_medis_id' => 'required|exists:rekam_medis,id',
            'obat_id'        => 'required|exists:obat,id',
            'jumlah'         => 'required|integer|min:1',
            'dosis'          => 'nullable|string|max:255',         // ✅ GANTI dari 'keterangan'
            'aturan_pakai'   => 'nullable|string|max:255',         // ✅ TAMBAHAN baru
        ]);

        Log::info('Validasi sukses');

        $obat = Obat::findOrFail($request->obat_id);
        if ($request->jumlah > $obat->stok) {
            Log::warning('Stok tidak cukup', ['stok' => $obat->stok, 'diminta' => $request->jumlah]);
            return back()->withErrors(['jumlah' => 'Jumlah melebihi stok tersedia'])->withInput();
        }

        $obat->stok -= $request->jumlah;
        $obat->save();
        Log::info('Stok berhasil dikurangi');

        $rekamMedis = RekamMedis::with('kunjungan')->findOrFail($request->rekam_medis_id);
        $pasienId = $rekamMedis->kunjungan->pasien_id;

        ResepObat::create([
            'rekam_medis_id' => $rekamMedis->id,
            'obat_id'        => $request->obat_id,
            'jumlah'         => $request->jumlah,
            'dosis'          => $request->dosis,
            'aturan_pakai'   => $request->aturan_pakai,
            'pasien_id'      => $pasienId,
        ]);

        Log::info('Resep berhasil disimpan');

        $kunjungan = $rekamMedis->kunjungan;
        $kunjungan->status = 'selesai';
        $kunjungan->save();

        Log::info('Status kunjungan diubah menjadi selesai');

        return redirect()->route('dokter.kunjungan.detail', $kunjungan->id)
            ->with('success', 'Resep berhasil disimpan dan kunjungan selesai.');
    }
    public function edit($id)
    {
        $resep = ResepObat::findOrFail($id);
        $obat = Obat::all(); // Jika kamu perlu dropdown pilihan obat
        return view('dokter.resep.edit', compact('resep', 'obat'));
    }

    public function destroy($id)
    {
        ResepObat::destroy($id);
        return redirect()->route('dokter.resep')->with('success', 'Resep berhasil dihapus.');
    }
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'obat_id' => 'required|exists:obat,id',
            'jumlah' => 'required|integer|min:1',
            'dosis' => 'nullable|string|max:255',
            'aturan_pakai' => 'nullable|string|max:255',
        ]);

        // Ambil data resep berdasarkan ID
        $resep = ResepObat::findOrFail($id);

        // Update data resep
        $resep->update([
            'obat_id' => $request->obat_id,
            'jumlah' => $request->jumlah,
            'dosis' => $request->dosis,
            'aturan_pakai' => $request->aturan_pakai,
        ]);

        // Redirect kembali ke halaman index dengan flash message
        return redirect()->route('dokter.resep')->with('success', 'Resep berhasil diperbarui.');
    }
}
