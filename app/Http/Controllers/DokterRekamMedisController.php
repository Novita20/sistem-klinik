<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DokterRekamMedisController extends Controller
{
    // Menampilkan list rekam medis untuk anamnesa
    public function anamnesa(Request $request)
    {
        $search = $request->input('search');

        $rekamMedis = RekamMedis::with('kunjungan.pasien.user')
            ->whereHas('kunjungan.pasien.user', function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                }
            })
            ->orderByDesc('created_at')
            ->paginate(10); // Ganti 10 sesuai jumlah per halaman

        return view('dokter.anamnesa', compact('rekamMedis', 'search'));
    }

    // Menampilkan data TTV dari paramedis
    public function ttv(Request $request)
    {
        $search = $request->input('search');

        $rekamMedis = RekamMedis::with('kunjungan.pasien.user')
            ->whereHas('kunjungan.pasien.user', function ($query) use ($search) {
                if ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                }
            })
            ->orderByDesc('created_at')
            ->paginate(10); // Ganti jumlah item per halaman sesuai kebutuhan

        return view('dokter.ttv', compact('rekamMedis', 'search'));
    }

    public function diagnosis(Request $request)
    {
        $kunjungan_id = $request->query('kunjungan_id');

        Log::info('Kunjungan ID:', ['id' => $kunjungan_id]);

        $kunjungan = null;
        if ($kunjungan_id) {
            $kunjungan = Kunjungan::with('pasien.user', 'rekamMedis')->find($kunjungan_id);
            Log::info('Data Kunjungan:', ['data' => $kunjungan]);
        }

        return view('dokter.diagnosis', ['kunjungan' => $kunjungan]);
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
            'diagnosis' => 'required|string',
            'tindakan' => 'required|string',
        ]);

        $rekam = RekamMedis::findOrFail($id);
        $rekam->diagnosis = $request->diagnosis;
        $rekam->tindakan = $request->tindakan;
        $rekam->save();

        // ✅ Update status kunjungan ke 'tindakan_dokter'
        if ($rekam->kunjungan) {
            $kunjungan = $rekam->kunjungan;
            $kunjungan->status = 'tindakan_dokter';
            $kunjungan->save();
        }

        return redirect()->back()->with('success', 'Diagnosa dan tindakan berhasil disimpan.');
    }
}
