<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\LogObat;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapObatExport;


class RekapObatController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : null;
        $end = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : null;

        $data = Obat::with(['logObat' => function ($query) use ($start, $end) {
            if ($start && $end) {
                $query->whereBetween('tgl_transaksi', [$start, $end]);
            }
        }])->get()->map(function ($obat) use ($start, $end) {
            $logMasuk = $obat->logObat->where('jenis_mutasi', 'masuk');
            $logKeluar = $obat->logObat->where('jenis_mutasi', 'keluar');

            return [
                'nama_obat' => $obat->nama_obat,
                'stok' => $obat->stok,
                'total_masuk' => $logMasuk->sum('jumlah'),
                'total_keluar' => $logKeluar->sum('jumlah'),
                'frekuensi' => $logKeluar->count(),
                'terakhir_digunakan' => $logKeluar->sortByDesc('tgl_transaksi')->first()?->tgl_transaksi,
            ];
        });

        return view('paramedis.rekap_obat', compact('data'));
    }

    public function exportExcel(Request $request)
    {
        $start = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : null;
        $end = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : null;

        $data = Obat::with(['logObat' => function ($query) use ($start, $end) {
            if ($start && $end) {
                $query->whereBetween('tgl_transaksi', [$start, $end]);
            }
        }])->get()->map(function ($obat) use ($start, $end) {
            $logMasuk = $obat->logObat->where('jenis_mutasi', 'masuk');
            $logKeluar = $obat->logObat->where('jenis_mutasi', 'keluar');

            return [
                'nama_obat' => $obat->nama_obat,
                'stok' => $obat->stok,
                'total_masuk' => $logMasuk->sum('jumlah'),
                'total_keluar' => $logKeluar->sum('jumlah'),
                'frekuensi' => $logKeluar->count(),
                'terakhir_digunakan' => optional($logKeluar->sortByDesc('tgl_transaksi')->first())->tgl_transaksi,
            ];
        });

        return Excel::download(new RekapObatExport($data), 'rekap-obat.xlsx');
    }
}
