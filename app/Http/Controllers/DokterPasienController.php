<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\RekamMedis;
use Barryvdh\DomPDF\Facade\Pdf;


class DokterPasienController extends Controller
{
    /**
     * Halaman daftar kunjungan pasien untuk dokter
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $kunjungan = Kunjungan::with([
            'pasien.user',
            'rekamMedis.resepObat.obat'
        ])
            ->when($search, function ($query, $search) {
                return $query->whereHas('pasien.user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->orderBy('tgl_kunjungan', 'desc')
            ->paginate(10) // ✅ pagination
            ->appends(['search' => $search]); // agar query tetap ada saat pindah halaman

        return view('dokter.kunjungan', compact('kunjungan', 'search'));
    }

    /**
     * Menampilkan detail 1 kunjungan
     */
    public function showKunjungan($id)
    {
        $kunjungan = Kunjungan::with([
            'pasien.user',
            'rekamMedis.resepObat.obat'
        ])->findOrFail($id); // Pastikan hanya 1 data

        return view('dokter.kunjungan_detail', compact('kunjungan'));
    }

    /**
     * Halaman diagnosis/rekam medis dokter
     */
    public function detailKunjungan($id)
    {
        $kunjungan = Kunjungan::with([
            'pasien.user',
            'rekamMedis.resepObat.obat'
        ])->findOrFail($id);

        // Simpan ke session (jika perlu)
        session(['kunjungan_id' => $kunjungan->id]);

        return view('dokter.diagnosis', compact('kunjungan'));
    }


    public function exportPdf($id)
    {
        $kunjungan = Kunjungan::with(['pasien.user', 'rekamMedis.resepObat.obat'])->findOrFail($id);

        $pdf = PDF::loadView('dokter.pdf.detail_kunj', compact('kunjungan'));
        return $pdf->download('kunjungan-pasien-' . $kunjungan->id . '.pdf');
    }

    /**
     * Menyimpan anamnesa dokter
     */
    public function store(Request $request)
    {
        $request->validate([
            'kunjungan_id' => 'required|exists:kunjungan,id',
            'anamnesa'     => 'required|string',
        ]);

        // Simpan anamnesa ke rekam medis
        $rekam = new RekamMedis();
        $rekam->kunjungan_id = $request->kunjungan_id;
        $rekam->anamnesa = $request->anamnesa;
        $rekam->save();

        // Update status kunjungan
        $kunjungan = Kunjungan::findOrFail($request->kunjungan_id);
        $kunjungan->status = 'anamnesa_dokter';
        $kunjungan->save();

        return redirect()->route('dokter.kunjungan.detail', $kunjungan->id)
            ->with('success', 'Anamnesa berhasil disimpan.');
    }
    public function edit($id)
    {
        $kunjungan = Kunjungan::with('pasien.user')->findOrFail($id);
        return view('dokter.kunjungan_edit', compact('kunjungan'));
    }

    public function update(Request $request, $id)
    {
        $kunjungan = Kunjungan::findOrFail($id);

        // Update data kunjungan
        $kunjungan->update([
            'tgl_kunjungan' => $request->tgl_kunjungan,
            'keluhan' => $request->keluhan,
            'status' => $request->status,
        ]);

        // Update rekam medis jika ada
        if ($kunjungan->rekamMedis) {
            $rekamMedis = $kunjungan->rekamMedis;
            $rekamMedis->update([
                'anamnesa' => $request->anamnesa,
                'diagnosis' => $request->diagnosis,
                'tindakan' => $request->tindakan,
            ]);

            // Update resep obat jika ada input
            if ($request->has('reseps')) {
                foreach ($request->reseps as $index => $resepInput) {
                    $resep = $rekamMedis->resepObat[$index] ?? null;

                    if ($resep) {
                        $resep->update([
                            'jumlah' => $resepInput['jumlah'],
                            'dosis' => $resepInput['dosis'],
                            'aturan_pakai' => $resepInput['aturan_pakai'],
                        ]);
                    }
                }
            }
        }

        return redirect()->route('dokter.kunjungan')->with('success', 'Data kunjungan berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $kunjungan = Kunjungan::findOrFail($id);

        // Opsional: Jika ada relasi data yang harus ikut dihapus
        if ($kunjungan->rekamMedis) {
            // Hapus resep obat dulu kalau ada
            if ($kunjungan->rekamMedis->resepObat) {
                $kunjungan->rekamMedis->resepObat()->delete();
            }

            // Hapus rekam medis
            $kunjungan->rekamMedis->delete();
        }

        // Terakhir, hapus kunjungan
        $kunjungan->delete();

        return redirect()->route('dokter.kunjungan')->with('success', 'Data kunjungan berhasil dihapus.');
    }
}
