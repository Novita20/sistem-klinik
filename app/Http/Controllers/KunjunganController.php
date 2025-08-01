<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pasien;
use App\Models\Kunjungan;
use Carbon\Carbon;

class KunjunganController extends Controller
{
    /**
     * 🔹 Form input kunjungan oleh pasien
     */
    public function create()
    {
        $user = Auth::user();
        $pasien = $user->pasien;

        return view('pasien.form', compact('pasien'));
    }

    /**
     * 🔹 Simpan kunjungan pasien ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nid'            => 'required|string|max:20',
            'nama'           => 'required|string|max:100',
            'tgl_kunjungan'  => 'required|date',
            'keluhan'        => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        $pasien = $user->pasien;

        // Buat data pasien jika belum ada
        if (!$pasien) {
            $pasien = Pasien::create([
                'user_id' => $user->id,
                'nid'     => $validated['nid'],
                'nama'    => $validated['nama'],
            ]);
        }

        // Ubah waktu kunjungan dari WIB ke UTC
        $tglKunjungan = Carbon::parse($validated['tgl_kunjungan'], 'Asia/Jakarta')->setTimezone('UTC');

        // Simpan data kunjungan
        Kunjungan::create([
            'pasien_id'     => $pasien->id,
            'tgl_kunjungan' => $tglKunjungan,
            'keluhan'       => $validated['keluhan'],
            'paramedis_id'  => null,
            'status'        => 'belum_ditangani',
        ]);

        return redirect()->route('kunjungan.riwayat')->with('success', 'Data kunjungan berhasil disimpan!');
    }

    /**
     * 📋 Riwayat kunjungan milik pasien yang sedang login
     */
    public function riwayat()
    {
        $user = Auth::user();
        $pasien = $user->pasien;

        $riwayat = $pasien
            ? Kunjungan::with('rekamMedis.dokter')->where('pasien_id', $pasien->id)->latest()->get()
            : collect();

        return view('pasien.riwayat', compact('riwayat'));
    }

    /**
     * 📋 Riwayat semua kunjungan untuk role paramedis
     */
    public function indexForParamedis()
    {
        if (Auth::user()->role !== 'paramedis') {
            abort(403, 'Unauthorized');
        }

        $kunjungan = Kunjungan::with(['pasien.user'])->latest()->get();

        return view('paramedis.kunjungan_index', compact('kunjungan'));
    }
}
