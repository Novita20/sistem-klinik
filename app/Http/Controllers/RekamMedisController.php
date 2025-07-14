<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Barryvdh\DomPDF\Facade\Pdf;

class RekamMedisController extends Controller
{
    /**
     * Menampilkan daftar rekam medis milik pasien yang sedang login.
     * Hanya untuk role "pasien".
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Cari ID pasien dari user_id yang sedang login
        $pasienId = Pasien::where('user_id', $user->id)->value('id');

        $rekammedis = RekamMedis::with([
            'kunjungan.pasien.user',
            'kunjungan',
            'resepObat.obat'
        ])
            ->whereHas('kunjungan', function ($query) use ($pasienId) {
                $query->where('pasien_id', $pasienId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pasien.rm', compact('rekammedis'));
    }
    public function show($id)
    {
        $rekamMedis = RekamMedis::with([
            'kunjungan.pasien.user',
            'resepObat.obat'
        ])->findOrFail($id);

        return view('sdm.rekammedis.detail', compact('rekamMedis'));
    }

    public function exportPdf($id)
    {
        $rekamMedis = RekamMedis::with(['kunjungan.pasien.user', 'resepObat.obat'])->findOrFail($id);

        $pdf = Pdf::loadView('sdm.rekammedis.pdf', compact('rekamMedis'));
        return $pdf->stream('rekam_medis_' . $rekamMedis->id . '.pdf');
    }


    /**
     * Menyimpan data rekam medis.
     * Hanya digunakan oleh dokter saat menangani pasien.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kunjungan_id' => 'required|exists:kunjungan,id',
            'ttv'          => 'required|string', // disimpan dalam bentuk JSON
            'diagnosa'     => 'required|string',
            'tindakan'     => 'required|string',
            'resep'        => 'nullable|string', // kalau tidak pakai model resep terpisah
        ]);

        RekamMedis::create([
            'kunjungan_id' => $request->kunjungan_id,
            'ttv'          => $request->ttv,
            'diagnosa'     => $request->diagnosa,
            'tindakan'     => $request->tindakan,
            'resep'        => $request->resep, // kolom opsional
            'dokter_id' => Auth::id(),
            'paramedis_id' => null, // karena disimpan oleh dokter
        ]);

        // Update status kunjungan menjadi 'sudah ditangani'
        Kunjungan::findOrFail($request->kunjungan_id)->update([
            'status' => 'sudah ditangani'
        ]);

        return redirect()->route('dokter.kunjungan')->with('success', 'Rekam medis berhasil disimpan.');
    }
}
