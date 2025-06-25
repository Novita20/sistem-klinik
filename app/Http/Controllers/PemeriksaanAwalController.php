<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PemeriksaanAwalController extends Controller
{
    /**
     * Menampilkan daftar kunjungan yang perlu diperiksa
     */
    public function index()
    {
        $kunjungan = Kunjungan::with('pasien.user')
            ->whereIn('status', ['menunggu_pemeriksaan_paramedis', 'selesai_pemeriksaan_paramedis']) // ✅ DUA STATUS
            ->orderByDesc('tgl_kunjungan')
            ->get();

        return view('paramedis.pemeriksaan_awal', compact('kunjungan'));
    }




    /**
     * Menampilkan form input pemeriksaan awal berdasarkan kunjungan
     */
    public function show($id)
    {
        $kunjungan = Kunjungan::with('pasien.user')->findOrFail($id);

        // Cek apakah status-nya valid untuk diperiksa paramedis
        if ($kunjungan->status !== 'menunggu_pemeriksaan_paramedis') {
            return redirect()->route('paramedis.pemeriksaan.awal')
                ->with('error', 'Kunjungan ini tidak dalam status pemeriksaan awal.');
        }

        return view('paramedis.pemeriksaan_awal_form', compact('kunjungan'));
    }





    public function store(Request $request)
    {
        $request->validate([
            'kunjungan_id' => 'required|exists:kunjungan,id',
            // lainnya...
        ]);

        // 1. Update status kunjungan
        $kunjungan = Kunjungan::findOrFail($request->kunjungan_id);

        $kunjungan->update([
            'status' => 'selesai_pemeriksaan_paramedis'
        ]);

        // 2. Simpan TTV ke rekam medis
        $rekamMedis = RekamMedis::firstOrCreate(
            ['kunjungan_id' => $request->kunjungan_id],
            ['ttv' => '{}']
        );

        $rekamMedis->update([
            'ttv' => json_encode([
                'tekanan_darah' => $request->tekanan_darah,
                'nadi'          => $request->nadi,
                'suhu'          => $request->suhu,
                'rr'            => $request->rr,
                'spo2'          => $request->spo2,
                'gda'           => $request->gda,
                'asam_urat'     => $request->asam_urat,
                'kolesterol'    => $request->kolesterol,
            ])
        ]);
        // Ubah status kunjungan ke 'selesai_pemeriksaan_paramedis'
        $kunjungan->status = 'selesai_pemeriksaan_paramedis';
        $kunjungan->save();

        return redirect()->route('paramedis.pemeriksaan.awal')->with('success', 'Pemeriksaan awal berhasil disimpan.');
    }
}
