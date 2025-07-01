<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HasilKunjunganController extends Controller
{
    /**
     * Menampilkan daftar kunjungan yang sedang berlangsung untuk paramedis
     */
    public function index()
    {
        $kunjungan = Kunjungan::with(['pasien.user'])
            ->whereIn('status', [
                'belum_ditangani', // mungkin untuk dokter
                'anamnesa_dokter', // selesai anamnesa, belum ke paramedis
                'menunggu_pemeriksaan_paramedis',
                'selesai_pemeriksaan_paramedis',
            ])
            ->latest('tgl_kunjungan')
            ->get();

        return view('paramedis.kunjungan_index', compact('kunjungan'));
    }

    /**
     * Menampilkan form rekam medis paramedis untuk kunjungan
     */
    public function create($kunjunganId)
    {
        $kunjungan = Kunjungan::with('pasien.user')->findOrFail($kunjunganId);
        return view('paramedis.rekam_medis', compact('kunjungan'));
    }
    /**
     * Menampilkan detail kunjungan
     */
    public function show($id)
    {
        $kunjungan = Kunjungan::with('pasien.user')->findOrFail($id);
        return view('paramedis.hasil_form', compact('kunjungan'));
    }

    /**
     * Menampilkan riwayat kunjungan paramedis
     */
    public function riwayat()
    {
        $riwayatKunjungan = Kunjungan::with('pasien.user')
            ->orderByDesc('tgl_kunjungan')
            ->get();

        return view('paramedis.riwayat_kunjungan', compact('riwayatKunjungan'));
    }


    /**
     * Simpan hasil pemeriksaan paramedis ke rekam medis
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
            'paramedis_id' => Auth::id(),
        ]);

        // Perbarui status kunjungan ke selesai_pemeriksaan_paramedis
        $kunjungan = Kunjungan::findOrFail($request->kunjungan_id);
        $kunjungan->status = 'selesai_pemeriksaan_paramedis';
        $kunjungan->save();

        return redirect()->route('paramedis.kunjungan.index')
            ->with('success', 'Rekam medis berhasil disimpan.');
    }
}
