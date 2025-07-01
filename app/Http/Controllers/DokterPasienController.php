<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\RekamMedis;

class DokterPasienController extends Controller
{
    // Halaman daftar kunjungan pasien untuk dokter
    public function index(Request $request)
    {
        $search = $request->input('search');

        $kunjungan = Kunjungan::with([
            'pasien.user',
            'rekamMedis.resepObat.obat' // ⬅️ Ini penting untuk menampilkan resep dan nama obat
        ])
            ->when($search, function ($query, $search) {
                return $query->whereHas('pasien.user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->orderBy('tgl_kunjungan', 'desc')
            ->paginate(10);

        return view('dokter.kunjungan', compact('kunjungan', 'search'));
    }



    public function showKunjungan($id)
    {
        $kunjungan = Kunjungan::with([
            'pasien.user',
            'rekamMedis.resepObat.obat'
        ])->get();

        dd($kunjungan); // LETAKKAN DI SINI

        return view('dokter.kunjungan', compact('kunjungan'));
    }



    // Menampilkan detail kunjungan untuk dokter
    public function detailKunjungan($id)
    {
        $kunjungan = Kunjungan::with(['pasien.user', 'rekamMedis'])->findOrFail($id);

        // Simpan ke session
        session(['kunjungan_id' => $kunjungan->id]);

        return view('dokter.diagnosis', compact('kunjungan'));
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
