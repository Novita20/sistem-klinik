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
        $user = Auth::user();
        $pasien = Pasien::where('user_id', $user->id)->first();

        $totalKunjungan = $pasien ? $pasien->kunjungan()->count() : 0;

        $kunjunganTerakhir = $pasien ? $pasien->kunjungan()->latest()->first() : null;
        $rekamMedisTerakhir = $kunjunganTerakhir ? $kunjunganTerakhir->rekamMedis : null;

        // ✅ Diagnosa terakhir
        $diagnosaTerakhir = $rekamMedisTerakhir ? $rekamMedisTerakhir->diagnosis : '-';

        // ✅ Tekanan darah terakhir
        $tekananDarahTerakhir = '-';
        if ($rekamMedisTerakhir && $rekamMedisTerakhir->ttv) {
            $ttv = json_decode($rekamMedisTerakhir->ttv, true);
            $tekananDarahTerakhir = $ttv['tekanan_darah'] ?? '-';
        }
        // ✅ Alternatif baru: status penanganan terakhir
        $kunjunganHariIni = $pasien
            ? $pasien->kunjungan()->whereDate('tgl_kunjungan', today())->exists()
            : false;

        return view('pasien.dashboard', compact(
            'totalKunjungan',
            'diagnosaTerakhir',
            'tekananDarahTerakhir',
            'rekamMedisTerakhir',
            'kunjunganHariIni'
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
