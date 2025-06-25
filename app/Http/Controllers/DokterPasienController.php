<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\RekamMedis;

class DokterPasienController extends Controller
{
    // Halaman daftar kunjungan pasien untuk dokter
    public function index()
    {
        $kunjungan = Kunjungan::with(['pasien.user', 'rekamMedis'])
            ->orderByDesc('tgl_kunjungan')
            ->get();

        return view('dokter.pasien', compact('kunjungan')); // view daftar kunjungan pasien
    }

    // Menampilkan semua kunjungan (tidak digunakan saat ini)
    public function showKunjungan($id)
    {
        $kunjungan = Kunjungan::with(['pasien.user'])->get();
        return view('dokter.kunjungan', compact('kunjungan'));
    }

    // Menampilkan detail kunjungan untuk dokter
    public function detailKunjungan($id)
    {
        $kunjungan = Kunjungan::with(['pasien.user', 'rekamMedis'])->findOrFail($id);
        return view('dokter.kunjungan_detail', compact('kunjungan'));
    }

    // Menyimpan anamnesa dokter
    public function store(Request $request)
    {
        $request->validate([
            'kunjungan_id' => 'required|exists:kunjungan,id',
            'anamnesa'     => 'required|string',
        ]);

        // Simpan ke tabel rekam medis
        $rekam = new RekamMedis();
        $rekam->kunjungan_id = $request->kunjungan_id;
        $rekam->anamnesa = $request->anamnesa;
        $rekam->save();

        // Ubah status kunjungan jadi 'anamnesa_dokter'
        $kunjungan = Kunjungan::findOrFail($request->kunjungan_id);
        $kunjungan->status = 'anamnesa_dokter';
        $kunjungan->save();

        return redirect()->route('dokter.kunjungan.detail', $kunjungan->id)
            ->with('success', 'Anamnesa berhasil disimpan.');
    }
}
