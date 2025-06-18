<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pasien;
use App\Models\Kunjungan;
use Carbon\Carbon;

class KunjunganController extends Controller
{
    // FORM INPUT KUNJUNGAN
    public function create()
    {
        $user = Auth::user();
        $pasien = $user->pasien;

        return view('pasien.form', compact('pasien'));
    }

    // PROSES SIMPAN KUNJUNGAN
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'tgl_kunjungan' => 'required|date',
            'keluhan' => 'required|string|max:1000',
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
        } else {
            // Update data pasien jika sudah ada
            $pasien->update([
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
            ]);
        }

        // Konversi dari WIB ke UTC
        $tglKunjungan = Carbon::parse($request->tgl_kunjungan, 'Asia/Jakarta')->setTimezone('UTC');

        Kunjungan::create([
            'pasien_id' => $pasien->id,
            'tgl_kunjungan' => $tglKunjungan,
            'keluhan' => $request->keluhan,
            'paramedis_id' => null,
        ]);

        return redirect()->route('kunjungan.riwayat')->with('success', 'Data kunjungan berhasil disimpan!');
    }

    // 🗂️ Riwayat kunjungan pasien
    public function riwayat()
    {
        $user = Auth::user();
        $pasien = $user->pasien;

        if ($pasien) {
            $riwayat = Kunjungan::where('pasien_id', $pasien->id)->latest()->get();
        } else {
            $riwayat = collect(); // Koleksi kosong supaya aman di view
        }

        return view('pasien.riwayat', compact('riwayat'));
    }

    // RIWAYAT KUNJUNGAN UNTUK PARAMEDIS
    public function indexForParamedis()
    {
        if (Auth::user()->role !== 'paramedis') {
            abort(403, 'Unauthorized');
        }

        $kunjungan = Kunjungan::with('pasien.user')->latest()->get();

        return view('paramedis.kunjungan_index', compact('kunjungan'));
    }
}
