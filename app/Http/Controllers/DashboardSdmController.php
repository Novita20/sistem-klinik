<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use App\Models\LogObat;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardSdmController extends Controller
{
    public function dashboard()
    {
        $totalRekamMedis = RekamMedis::count();
        $totalObatDigunakan = LogObat::where('jenis_mutasi', 'keluar')->count();
        $obatHampirHabis = Obat::where('stok', '<', 5)->count();

        // Chart Diagnosa: hitung berdasarkan field diagnosa di tabel rekam_medis
        $diagnosaData = RekamMedis::select('diagnosis', DB::raw('count(*) as jumlah'))
            ->groupBy('diagnosis')
            ->orderByDesc('jumlah')
            ->take(5)
            ->get();

        $diagnosaLabels = $diagnosaData->pluck('diagnosis');
        $diagnosaCounts = $diagnosaData->pluck('jumlah');

        $chartDiagnosaUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode([
            "type" => "bar",
            "data" => [
                "labels" => $diagnosaLabels,
                "datasets" => [[
                    "label" => "Diagnosa",
                    "data" => $diagnosaCounts,
                    "backgroundColor" => "indigo"
                ]]
            ]
        ]));

        // Chart Penggunaan Obat: join dengan tabel obat
        $obatData = LogObat::select('obat.nama_obat', DB::raw('count(*) as jumlah'))
            ->join('obat', 'log_obat.obat_id', '=', 'obat.id')
            ->where('jenis_mutasi', 'keluar')
            ->groupBy('obat.nama_obat')
            ->orderByDesc('jumlah')
            ->take(5)
            ->get();

        $obatLabels = $obatData->pluck('nama_obat');
        $obatCounts = $obatData->pluck('jumlah');

        $chartObatUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode([
            "type" => "pie",
            "data" => [
                "labels" => $obatLabels,
                "datasets" => [["data" => $obatCounts]]
            ]
        ]));

        // Rekam medis terakhir
        $rekamTerakhir = RekamMedis::with(['kunjungan.pasien.user'])
            ->latest()
            ->take(5)
            ->get();

        return view('sdm.dashboard', compact(
            'totalRekamMedis',
            'totalObatDigunakan',
            'obatHampirHabis',
            'chartDiagnosaUrl',
            'chartObatUrl',
            'rekamTerakhir'
        ));
    }
}
