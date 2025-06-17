<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pasien;
use App\Models\Kunjungan;

class HomePasienController extends Controller
{
    public function index()
    {
        $totalKunjungan = 5;
        $kunjunganTerakhir = null;
        $diagnosaTerakhir = '-';

        return view('pasien.dashboard', compact(
            'totalKunjungan',
            'kunjunganTerakhir',
            'diagnosaTerakhir'
        ));
    }


    public function create()
    {
        $user = Auth::user();
        $pasien = $user->pasien; // pastikan relasi user-pasien ada di model User

        return view('pasien.dashboard', compact('pasien'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'keluhan' => 'required|string|max:255',
        ]);

        $pasien = Pasien::where('user_id', Auth::id())->first();

        if (!$pasien) {
            return redirect()->back()->withErrors('Data pasien tidak ditemukan.');
        }

        Kunjungan::create([
            'id_pasien' => $pasien->id,
            'keluhan' => $request->keluhan,
            'tanggal_kunjungan' => now(),
        ]);

        return redirect()->route('kunjungan.form')->with('success', 'Kunjungan berhasil disimpan.');
    }
}
