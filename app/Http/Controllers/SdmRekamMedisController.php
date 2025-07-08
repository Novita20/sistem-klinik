<?php

namespace App\Http\Controllers;

use App\Exports\SdmRekamMedisExport;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SdmRekamMedisController extends Controller
{
    public function index(Request $request)
    {
        $query = RekamMedis::with(['kunjungan.pasien.user', 'resepObat.obat']);

        // Jika ada pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('kunjungan.pasien.user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }

        $rekammedis = $query->latest()->paginate(10);

        return view('sdm.rekamMedis.index', compact('rekammedis'));
    }
    public function export(Request $request)
    {
        return Excel::download(new SdmRekamMedisExport($request), 'rekam_medis_sdm.xlsx');
    }
}
