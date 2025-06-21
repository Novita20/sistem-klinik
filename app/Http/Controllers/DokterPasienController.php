<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;

class DokterPasienController extends Controller
{
    public function index()
    {
        $kunjungan = Kunjungan::with(['pasien.user', 'rekamMedis'])
            ->orderByDesc('tgl_kunjungan')
            ->get();

        return view('dokter.pasien', compact('kunjungan')); // BUKAN dokter.kunjungan_index
    }


    public function showKunjungan($id)
    {
        // Ambil data kunjungan beserta user pasien dan rekam medis (jika ada)
        $kunjungan = Kunjungan::with(['pasien.user'])->get();
        return view('dokter.kunjungan', compact('kunjungan'));
    }
    public function detailKunjungan($id)
    {
        $kunjungan = Kunjungan::with(['pasien.user', 'rekamMedis'])->findOrFail($id); // ✅ ambil satu kunjungan saja
        return view('dokter.kunjungan_detail', compact('kunjungan')); // arahkan ke view detail, bukan yang tabel
    }
}
