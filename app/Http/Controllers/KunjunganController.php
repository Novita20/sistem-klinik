<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pasien;
use App\Models\Kunjungan;
use Carbon\Carbon;

class KunjunganController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $pasien = $user->pasien; // pastikan relasi user -> pasien sudah ada

        return view('pasien.form', compact('pasien'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'keluhan' => 'required|string',
            'tgl_kunjungan' => 'required|date', // tambahkan validasi input waktu
        ]);

        $user = Auth::user();
        $pasien = $user->pasien;

        if (!$pasien) {
            $pasien = Pasien::create([
                'user_id' => $user->id,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'status' => 'aktif',
                'alamat' => '',
                'no_hp' => '',
            ]);
        }

        // KONVERSI DARI WIB KE UTC sebelum simpan
        $tglKunjungan = Carbon::parse($request->tgl_kunjungan, 'Asia/Jakarta')->setTimezone('UTC');

        Kunjungan::create([
            'pasien_id' => $pasien->id,
            'tgl_kunjungan' => $tglKunjungan,
            'keluhan' => $request->keluhan,
            'paramedis_id' => null,
        ]);

        return redirect()->back()->with('success', 'Data kunjungan berhasil disimpan!');
    }





    public function riwayat()
    {
        $pasien = Pasien::where('user_id', Auth::id())->first();

        if (!$pasien) {
            return redirect()->back()->with('error', 'Data pasien belum ditemukan.');
        }

        $riwayat = Kunjungan::where('pasien_id', $pasien->id)->latest()->get();

        return view('pasien.riwayat', compact('riwayat'));
    }


    public function indexForParamedis()
    {
        // Cek apakah user adalah paramedis
        if (Auth::user()->role !== 'paramedis') {
            abort(403, 'Unauthorized');
        }

        // Ambil semua data kunjungan dan relasi pasien + user
        $kunjungan = Kunjungan::with('pasien.user')->latest()->get();

        return redirect()->back()->with('success', 'Data kunjungan berhasil disimpan!');
    }
}
