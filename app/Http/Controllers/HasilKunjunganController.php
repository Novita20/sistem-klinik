<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HasilKunjunganController extends Controller
{
    // 🟢 Menampilkan daftar kunjungan yang belum ditangani (atau belum punya status)
    public function index()
    {
        $kunjungan = Kunjungan::with(['pasien.user'])
            ->where(function ($query) {
                $query->whereNull('status')
                    ->orWhere('status', 'belum ditangani');
            })
            ->latest()
            ->get();

        return view('paramedis.kunjungan_index', compact('kunjungan'));
    }

    // 🟢 Menampilkan form rekam medis untuk kunjungan tertentu
    public function create($kunjunganId)
    {
        $kunjungan = Kunjungan::findOrFail($kunjunganId);
        return view('paramedis.rekam_medis', compact('kunjungan'));
    }

    // 🟢 Menampilkan detail kunjungan
    public function show($id)
    {
        $kunjungan = Kunjungan::with('pasien.user')->findOrFail($id);
        return view('paramedis.hasil_form', compact('kunjungan'));
    }

    // 🟢 Menampilkan riwayat kunjungan paramedis
    public function riwayat()
    {
        $riwayatKunjungan = Kunjungan::with('pasien.user')
            ->orderByDesc('tgl_kunjungan')
            ->get();

        return view('paramedis.riwayat_kunjungan', compact('riwayatKunjungan'));
    }

    // 🟢 Menyimpan hasil rekam medis dari paramedis
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kunjungan_id' => 'required|exists:kunjungan,id',
            'ttv'          => 'required|string',
            'diagnosa'     => 'required|string',
            'tindakan'     => 'required|string',
            'resep'        => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        RekamMedis::create([
            'kunjungan_id' => $request->kunjungan_id,
            'ttv'          => $request->ttv,
            'diagnosa'     => $request->diagnosa,
            'tindakan'     => $request->tindakan,
            'resep'        => $request->resep,
            'paramedis_id' => Auth::id(),
            'dokter_id'    => null,
        ]);

        // ✅ Update status kunjungan jadi 'sudah ditangani'
        Kunjungan::findOrFail($request->kunjungan_id)->update(['status' => 'sudah ditangani']);

        return redirect()->route('paramedis.kunjungan.index')->with('success', 'Rekam medis berhasil disimpan.');
    }
}
