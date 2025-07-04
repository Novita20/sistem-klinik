<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\LogObat;
use Illuminate\Http\Request;
use Carbon\Carbon;
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

            $expired_at = $obat->expired_at;

            // Hitung warna berdasarkan jarak ke tanggal kadaluarsa
            $expired_color = 'inherit';
            if ($expired_at) {
                $now = Carbon::now();
                $exp = Carbon::parse($expired_at);
                $diffInMonths = $now->diffInMonths($exp, false); // false agar bisa negatif kalau sudah kadaluarsa

                if ($diffInMonths < 1) {
                    $expired_color = 'black';
                } elseif ($diffInMonths < 2) {
                    $expired_color = 'red';
                } elseif ($diffInMonths < 3) {
                    $expired_color = 'orange';
                }
            }

            return [
                'nama_obat' => $obat->nama_obat,
                'jenis_obat' => $obat->jenis_obat ?? '-',
                'satuan' => $obat->satuan,
                'stok' => $obat->stok,
                'total_masuk' => $masuk,
                'total_keluar' => $keluar,
                'digunakan' => $obat->logObat->where('jenis_mutasi', 'keluar')->count(),
                'rata_rata_bulanan' => $keluar > 0
                    ? round($keluar / max(1, $obat->logObat
                        ->where('jenis_mutasi', 'keluar')
                        ->groupBy(fn($item) => Carbon::parse($item->tgl_transaksi)->format('Y-m'))
                        ->count()))
                    : 0,
                'terakhir_digunakan' => $terakhir_digunakan,
                'expired_at' => $expired_at,
                'expired_color' => $expired_color, // <- ini ditambahkan
            ];
        });

        return view('paramedis.rekap_obat', compact('data'));
    }
}
