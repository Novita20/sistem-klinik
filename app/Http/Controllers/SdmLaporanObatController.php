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
    public function index(Request $request)
    {
        $query = ResepObat::with('obat');

        // Filter tanggal penggunaan obat
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

        // Grouping berdasarkan kombinasi: obat_id + tanggal penggunaan
        $grouped = $resepList->groupBy(function ($item) {
            return $item->obat_id . '|' . $item->created_at->format('Y-m-d');
        });

        // Format data agar tidak hilang tiap pemakaian per hari
        $data = $grouped->map(function ($items) {
            $first = $items->first();
            return [
                'nama_obat' => $first->obat->nama_obat ?? '-',
                'frekuensi' => $items->count(),
                'terakhir_digunakan' => $first->created_at->format('d-m-Y'),
            ];
        })->values()->all();

        return view('sdm.laporan.index', compact('data'));
    }
}
