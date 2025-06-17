<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\LogObat;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RekapObatController extends Controller
{
    public function index()
    {
        $data = Obat::with('logObat')->get()->map(function ($obat) {
            $masuk = $obat->logObat->where('jenis_mutasi', 'masuk')->sum('jumlah');
            $keluar = $obat->logObat->where('jenis_mutasi', 'keluar')->sum('jumlah');
            $terakhir_digunakan = $obat->logObat
                ->where('jenis_mutasi', 'keluar')
                ->sortByDesc('tgl_transaksi')
                ->first()?->tgl_transaksi;
            $exp_terdekat = $obat->logObat
                ->whereNotNull('tgl_exp')
                ->sortBy('tgl_exp')
                ->first()?->tgl_exp;

            return [
                'nama_obat' => $obat->nama_obat,
                'jenis_obat' => $obat->jenis_obat ?? '-',
                'satuan' => $obat->satuan,
                'stok' => $obat->stok,
                'total_masuk' => $masuk,
                'total_keluar' => $keluar,
                'digunakan' => $obat->logObat->where('jenis_mutasi', 'keluar')->count(),
                'rata_rata_bulanan' => $keluar > 0 ? round($keluar / max(1, $obat->logObat->groupBy(function ($item) {
                    return Carbon::parse($item->tgl_transaksi)->format('Y-m');
                })->count())) : 0,
                'terakhir_digunakan' => $terakhir_digunakan,
                'exp_terdekat' => $exp_terdekat,
            ];
        });

        return view('paramedis.rekap_obat', compact('data'));
    }
}
