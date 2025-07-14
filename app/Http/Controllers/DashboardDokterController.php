<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kunjungan;
use App\Models\RekamMedis;
use Illuminate\Support\Facades\DB;

class DashboardDokterController extends Controller
{
    public function dashboard()
    {
        // Total data
        $totalKunjungan = Kunjungan::count();
        $totalRekamMedis = RekamMedis::count();
        $idKunjunganTertangani = RekamMedis::pluck('kunjungan_id')->toArray();
        $kunjunganBelumDitangani = Kunjungan::whereNotIn('id', $idKunjunganTertangani)->count();

        // Rekam medis terakhir
        $rekamTerakhir = RekamMedis::with(['kunjungan.pasien.user'])
            ->latest()
            ->take(5)
            ->get();

        // Grafik Kunjungan Minggu Ini (Line Chart)
        $labelsKunjungan = [];
        $dataKunjungan = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);
            $labelsKunjungan[] = $tanggal->format('D'); // e.g. Sen, Sel
            $dataKunjungan[] = Kunjungan::whereDate('tgl_kunjungan', $tanggal)->count();
        }

        $chartKunjunganUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode([
            'type' => 'line',
            'data' => [
                'labels' => $labelsKunjungan,
                'datasets' => [[
                    'label' => 'Kunjungan',
                    'data' => $dataKunjungan,
                    'fill' => false,
                    'borderColor' => 'blue',
                ]]
            ]
        ]));

        // Grafik Penyakit Terbanyak (Pie Chart)
        $penyakit = RekamMedis::select('diagnosis', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('diagnosis')
            ->orderByDesc('jumlah')
            ->limit(5)
            ->get();

        $labelPenyakit = $penyakit->pluck('diagnosis')->toArray();
        $dataPenyakit = $penyakit->pluck('jumlah')->toArray();

        $chartPenyakitUrl = 'https://quickchart.io/chart?c=' . urlencode(json_encode([
            'type' => 'pie',
            'data' => [
                'labels' => $labelPenyakit,
                'datasets' => [['data' => $dataPenyakit]]
            ]
        ]));

        return view('dokter.dashboard', compact(
            'totalKunjungan',
            'totalRekamMedis',
            'kunjunganBelumDitangani',
            'rekamTerakhir',
            'chartKunjunganUrl',
            'chartPenyakitUrl'
        ));
    }
}
