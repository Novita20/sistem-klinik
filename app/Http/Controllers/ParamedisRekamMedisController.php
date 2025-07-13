<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekamMedis;
use App\Models\Kunjungan;
use App\Exports\ParamedisRekamMedisExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ParamedisRekamMedisController extends Controller
{
    public function index(Request $request)
    {

        $query = RekamMedis::with(['kunjungan.pasien.user', 'resepObat.obat']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('kunjungan.pasien.user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $rekammedis = $query->latest()->paginate(10);
        return view('paramedis.rekammedis.rm_index', compact('rekammedis'));
    }
    public function export(Request $request)
    {
        $search = $request->input('search');
        return Excel::download(new ParamedisRekamMedisExport($search), 'rekam_medis.xlsx');
    }

    public function create($kunjunganId)
    {
        $kunjungan = Kunjungan::with('pasien.user')->findOrFail($kunjunganId);
        return view('paramedis.rekammedis.rm_create', compact('kunjungan'));
    }

    public function show($id)
    {
        $rm = RekamMedis::with(['kunjungan.pasien.user', 'resepObat.obat'])->findOrFail($id);
        return view('paramedis.rekammedis.rm_detail', compact('rm'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kunjungan_id'   => 'required|exists:kunjungan,id',
            'tekanan_darah'  => 'nullable|string|max:10',
            'suhu'           => 'nullable|numeric',
            'nadi'           => 'nullable|integer',
            'pernapasan'     => 'nullable|integer',
            'tinggi_badan'   => 'nullable|numeric',
            'berat_badan'    => 'nullable|numeric',
            'diagnosa'       => 'required|string',
            'tindakan'       => 'nullable|string',
            'resep'          => 'nullable|string',
        ]);

        RekamMedis::create($request->all());

        return redirect()->route('paramedis.rekammedis.index')->with('success', 'Rekam medis berhasil disimpan.');
    }

    public function edit($id)
    {
        $rekammedis = RekamMedis::with('kunjungan.pasien.user')->findOrFail($id);
        return view('paramedis.rekammedis.rm_edit', compact('rekammedis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'diagnosis'   => 'required|string',
            'tindakan'    => 'nullable|string',
            'anamnesa'    => 'nullable|string',
            // Tambahkan validasi lain sesuai kebutuhan
        ]);

        $rekammedis = RekamMedis::findOrFail($id);
        $rekammedis->update($request->all());

        return redirect()->route('paramedis.rekammedis.index')->with('success', 'Rekam medis berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $rekammedis = RekamMedis::findOrFail($id);
        $rekammedis->delete();

        return redirect()->route('paramedis.rekammedis.index')->with('success', 'Rekam medis berhasil dihapus.');
    }

    public function downloadPDF($id)
    {
        $rm = RekamMedis::with(['kunjungan.pasien.user', 'resepObat.obat'])->findOrFail($id);
        $pdf = Pdf::loadView('paramedis.rekamMedis.rm_pdf', compact('rm'));
        return $pdf->download('rekam_medis_' . $rm->id . '.pdf');
    }
}
