<?php

namespace App\Http\Controllers;

use App\Models\RestockObat;
use App\Models\LogObat;
use App\Models\Obat;
use Illuminate\Http\Request;

class DashboardK3Controller extends Controller
{
    public function dashboard()
    {
        // Jumlah total pengajuan restock obat
        $totalRestock = RestockObat::count();

        // Jumlah log penggunaan obat (jenis keluar)
        $totalPenggunaan = LogObat::where('jenis_mutasi', 'keluar')->count();

        // Jumlah obat yang hampir habis (stok di bawah ambang batas, misal <10)
        $obatHampirHabis = Obat::where('stok', '<', 5)->count();

        // ⬇️ Chart Dummy (bisa diganti dengan chart dinamis nantinya)
        $chartRestockUrl = 'https://quickchart.io/chart?c={type:"bar",data:{labels:["Sen","Sel","Rab","Kam","Jum","Sab","Min"],datasets:[{label:"Pengajuan",data:[2,3,1,4,2,0,1],backgroundColor:"blue"}]}}';
        $chartObatUrl = 'https://quickchart.io/chart?c={type:"pie",data:{labels:["Paracetamol","Amoxicillin","Antalgin","CTM"],datasets:[{data:[25,18,15,10]}]}}';

        return view('k3.dashboard', compact(
            'totalRestock',
            'totalPenggunaan',
            'obatHampirHabis',
            'chartRestockUrl',
            'chartObatUrl'
        ));
    }
}
