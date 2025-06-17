<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HasilKunjunganController extends Controller
{
    public function create($kunjunganId)
    {
        $kunjungan = Kunjungan::findOrFail($kunjunganId);
        return view('paramedis.rekam_medis', compact('kunjungan'));
    }

    public function index()
    {
        $kunjungan = Kunjungan::with(['pasien.user'])
            ->where('status', 'belum ditangani')
            ->get();

        return view('paramedis.kunjungan_index', compact('kunjungan'));
    }

    public function show($id)
    {
        $kunjungan = Kunjungan::with('pasien.user')->findOrFail($id);
        return view('paramedis.hasil_form', compact('kunjungan'));
    }

    public function riwayat()
    {
        $riwayatKunjungan = Kunjungan::with('pasien.user')
            ->orderBy('tgl_kunjungan', 'desc')
            ->get();

        return view('paramedis.riwayat_kunjungan', compact('riwayatKunjungan'));
    }

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
            'paramedis_id' => auth()->id(),
            'dokter_id'    => null,
        ]);

        Kunjungan::findOrFail($request->kunjungan_id)->update(['status' => 'ditangani']);

        return redirect()->route('paramedis.kunjungan.index')->with('success', 'Rekam medis berhasil disimpan.');
    }
}
