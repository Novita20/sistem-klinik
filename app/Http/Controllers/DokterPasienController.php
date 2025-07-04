<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\RekamMedis;

class DokterPasienController extends Controller
{
    /**
     * Halaman daftar kunjungan pasien untuk dokter
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $kunjungan = Kunjungan::with([
            'pasien.user',
            'rekamMedis.resepObat.obat'
        ])
            ->when($search, function ($query, $search) {
                return $query->whereHas('pasien.user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->orderBy('tgl_kunjungan', 'desc')
            ->paginate(10) // ✅ pagination
            ->appends(['search' => $search]); // agar query tetap ada saat pindah halaman

        return view('dokter.kunjungan', compact('kunjungan', 'search'));
    }

    /**
     * Menampilkan detail 1 kunjungan
     */
    public function showKunjungan($id)
    {
        $kunjungan = Kunjungan::with([
            'pasien.user',
            'rekamMedis.resepObat.obat'
        ])->findOrFail($id); // Pastikan hanya 1 data

        return view('dokter.kunjungan_detail', compact('kunjungan'));
    }

    /**
     * Halaman diagnosis/rekam medis dokter
     */
    public function detailKunjungan($id)
    {
        $kunjungan = Kunjungan::with([
            'pasien.user',
            'rekamMedis.resepObat.obat'
        ])->findOrFail($id);

        // Simpan ke session (jika perlu)
        session(['kunjungan_id' => $kunjungan->id]);

        return view('dokter.diagnosis', compact('kunjungan'));
    }

    /**
     * Menyimpan anamnesa dokter
     */
    public function store(Request $request)
    {
        $request->validate([
            'kunjungan_id' => 'required|exists:kunjungan,id',
            'anamnesa'     => 'required|string',
        ]);

        // Simpan anamnesa ke rekam medis
        $rekam = new RekamMedis();
        $rekam->kunjungan_id = $request->kunjungan_id;
        $rekam->anamnesa = $request->anamnesa;
        $rekam->save();

        // Update status kunjungan
        $kunjungan = Kunjungan::findOrFail($request->kunjungan_id);
        $kunjungan->status = 'anamnesa_dokter';
        $kunjungan->save();

        return redirect()->route('dokter.kunjungan.detail', $kunjungan->id)
            ->with('success', 'Anamnesa berhasil disimpan.');
    }
}
