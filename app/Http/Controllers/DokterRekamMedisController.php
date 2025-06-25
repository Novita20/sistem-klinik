<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use App\Models\Kunjungan;
use Illuminate\Http\Request;

class DokterRekamMedisController extends Controller
{
    // Menampilkan list rekam medis untuk anamnesa
    public function anamnesa()
    {
        $rekamMedis = RekamMedis::with('kunjungan.pasien.user')
            ->orderByDesc('created_at')
            ->get();

        return view('dokter.anamnesa', compact('rekamMedis'));
    }

    // Menampilkan data TTV dari paramedis
    public function ttv()
    {
        $rekamMedis = RekamMedis::with('kunjungan.pasien.user')->get();

        return view('dokter.ttv', compact('rekamMedis'));
    }

    // Form diagnosis
    public function diagnosis()
    {
        return view('dokter.diagnosis');
    }

    // Form tindakan
    public function tindakan()
    {
        return view('dokter.tindakan');
    }

    /**
     * Simpan anamnesa dari dokter
     */
    public function store(Request $request)
    {
        $request->validate([
            'kunjungan_id' => 'required|exists:kunjungan,id',
            'anamnesa'     => 'required|string',
        ]);

        $rekam = new RekamMedis();
        $rekam->kunjungan_id = $request->kunjungan_id;
        $rekam->anamnesa = $request->anamnesa;
        $rekam->save();

        // ✅ Update status ke anamnesa_dokter
        $kunjungan = Kunjungan::findOrFail($request->kunjungan_id);
        $kunjungan->status = 'anamnesa_dokter';
        $kunjungan->save();

        return redirect()->route('dokter.kunjungan.detail', $kunjungan->id)
            ->with('success', 'Anamnesa berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'diagnosa' => 'required|string',
            'tindakan' => 'required|string',
            'resep'    => 'nullable|string',
        ]);

        $rekam = RekamMedis::findOrFail($id);
        $rekam->diagnosa = $request->diagnosa;
        $rekam->tindakan = $request->tindakan;
        $rekam->resep = $request->resep;
        $rekam->save();

        // ✅ Update status ke selesai_pemeriksaan_dokter
        $kunjungan = Kunjungan::findOrFail($rekam->kunjungan_id);
        $kunjungan->status = 'selesai_pemeriksaan_dokter';
        $kunjungan->save();

        return redirect()->route('dokter.kunjungan.detail', $rekam->kunjungan_id)
            ->with('success', 'Diagnosa dan tindakan berhasil diperbarui.');
    }
}
