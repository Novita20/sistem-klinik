<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kunjungan;
use App\Models\RekamMedis;

class RekamMedisController extends Controller
{
    /**
     * Tampilkan rekam medis untuk pasien yang sedang login
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil kunjungan pasien beserta data rekam medis (jika ada)
        $rekamMedis = Kunjungan::with('rekamMedis')
            ->where('pasien_id', $user->id)
            ->orderBy('tgl_kunjungan', 'desc')
            ->get();

        return view('pasien.rm', compact('rekamMedis'));
    }

    /**
     * Simpan data rekam medis dari dokter
     */
    public function store(Request $request)
    {
        $request->validate([
            'kunjungan_id' => 'required|exists:kunjungan,id',
            'ttv'          => 'required|string',
            'diagnosa'     => 'required|string',
            'tindakan'     => 'required|string',
            'resep'        => 'nullable|string',
        ]);

        RekamMedis::create([
            'kunjungan_id' => $request->kunjungan_id,
            'ttv'          => $request->ttv,
            'diagnosa'     => $request->diagnosa,
            'tindakan'     => $request->tindakan,
            'resep'        => $request->resep,
            'dokter_id'    => auth()->id(),
            'paramedis_id' => null,
        ]);

        Kunjungan::findOrFail($request->kunjungan_id)->update([
            'status' => 'sudah ditangani'
        ]);

        return redirect()->route('dokter.kunjungan')->with('success', 'Rekam medis berhasil disimpan.');
    }
}
