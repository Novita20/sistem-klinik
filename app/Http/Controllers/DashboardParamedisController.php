<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\RekamMedis;
use App\Models\ResepObat;
use App\Models\Obat;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class DashboardParamedisController extends Controller
{
    public function index()
    {
        // Pasien hari ini (benar-benar berdasarkan tanggal hari ini)
        $totalKunjungan = Kunjungan::count();



        // Total seluruh data
        $totalRekamMedis = RekamMedis::count();
        $totalResepObat = ResepObat::count();

        // Obat hampir habis (<5 stok) dan mendekati kadaluarsa (dalam 30 hari ke depan)
        $jumlahObatHampirHabis = Obat::where('stok', '<', 5)->count();
        $jumlahObatKadaluarsa = Obat::whereDate('expired_at', '<=', Carbon::now()->addDays(30))->count();

        $obatHampirHabisList = Obat::where('stok', '<', 5)->get();
        $obatKadaluarsaList = Obat::whereDate('expired_at', '<=', Carbon::now()->addDays(30))->get();

        // Grafik Kunjungan Pasien Per Bulan (otomatis dari database)
        $riwayatKunjungan = Kunjungan::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get();

        $bulanLabels = [];
        $jumlahKunjungan = [];

        $namaBulan = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'];

        for ($i = 1; $i <= 12; $i++) {
            $bulanLabels[] = $namaBulan[$i];
            $data = $riwayatKunjungan->firstWhere('bulan', $i);
            $jumlahKunjungan[] = $data ? $data->total : 0;
        }

        return view('paramedis.dashboard', compact(
            'totalKunjungan',
            'totalRekamMedis',
            'totalResepObat',
            'jumlahObatHampirHabis',
            'jumlahObatKadaluarsa',
            'obatHampirHabisList',
            'obatKadaluarsaList',
            'bulanLabels',
            'jumlahKunjungan'
        ));
    }
}
