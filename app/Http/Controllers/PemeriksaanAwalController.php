<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Illuminate\Http\Request;

class PemeriksaanAwalController extends Controller
{
    public function index()
    {
        $kunjungan = Kunjungan::with(['pasien.user'])
            ->where('status', 'belum ditangani')
            ->get();

        return view('paramedis.pemeriksaan_awal', compact('kunjungan'));
    }

    public function show($id)
    {
        $kunjungan = Kunjungan::with('pasien.user')->findOrFail($id);
        return view('paramedis.pemeriksaan_awal_form', compact('kunjungan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kunjungan_id' => 'required|exists:kunjungan,id',
            'tekanan_darah' => 'nullable|string',
            'nadi'          => 'nullable|string',
            'suhu'          => 'nullable|string',
            'rr'            => 'nullable|string',
            'spo2'          => 'nullable|string',
            'gda'           => 'nullable|string',
            'asam_urat'     => 'nullable|string',
            'kolesterol'    => 'nullable|string',
        ]);

        // Simpan ke tabel lain jika ada, atau bisa disimpan sebagai bagian dari `RekamMedis`
        // Sementara hanya ditampilkan sebagai dump atau simpan log
        return redirect()->route('paramedis.pemeriksaan.awal')
            ->with('success', 'Data pemeriksaan awal berhasil disimpan.');
    }
}
