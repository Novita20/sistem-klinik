<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResepObat;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanObatExport;
use App\Exports\SdmLaporanObatExport;

class SdmLaporanObatController extends Controller
{
    // 🔍 Tampilkan laporan di blade
    public function index(Request $request)
    {
        $query = ResepObat::with('obat');

        // Filter berdasarkan tanggal kunjungan (created_at dari resep)
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter berdasarkan nama obat
        if ($request->filled('search')) {
            $query->whereHas('obat', function ($q) use ($request) {
                $q->where('nama_obat', 'like', '%' . $request->search . '%');
            });
        }

        $resepList = $query->get();

        // Proses data menjadi laporan ringkas (group by nama_obat)
        $data = $resepList->groupBy('obat_id')->map(function ($items) {
            $first = $items->first();
            return [
                'nama_obat' => $first->obat->nama_obat ?? '-',
                'frekuensi' => $items->count(),
                'terakhir_digunakan' => $items->max('created_at'),
            ];
        })->sortByDesc('frekuensi')->values()->all();

        return view('sdm.laporan.index', compact('data'));
    }

    // 📥 Export ke Excel
    public function export(Request $request)
    {
        return Excel::download(new SdmLaporanObatExport($request), 'laporan_penggunaan_obat.xlsx');
    }
}
