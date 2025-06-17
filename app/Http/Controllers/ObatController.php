<?php

namespace App\Http\Controllers;

use App\Models\LogObat;
use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    // Menampilkan semua data obat + search & pagination
    // Tampilkan halaman list obat
    public function index(Request $request)
    {
        $query = Obat::query();

        if ($request->filled('search')) {
            $query->where('nama_obat', 'like', '%' . $request->search . '%');
        }

        $obats = $query->orderBy('nama_obat')->paginate(10);

        // PANGGIL VIEW SESUAI PATH
        return view('paramedis.obat.index', compact('obats'));
    }

    // Tampilkan form input obat
    public function create()
    {
        // PANGGIL VIEW SESUAI PATH
        return view('paramedis.obat.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_obat'   => 'required|string|max:255',
            'jenis_obat'  => 'required|string|max:255',
            'stok'        => 'required|integer|min:0',
            'satuan'      => 'required|string|max:50',
            'expired_at'  => 'required|date',
        ]);

        // Simpan obat
        $obat = Obat::create($request->all());

        // Catat ke mutasi (log_obat)
        LogObat::create([

            'obat_id'       => $obat->id,
            'jenis_mutasi'  => 'masuk',
            'jumlah'        => $obat->stok,
            'sisa_stok'     => $obat->stok,
            'tgl_transaksi' => now(),
            'tgl_exp'       => $obat->expired_at,
            'keterangan'    => 'Input awal obat',
            'ref_type'      => 'obat',
            'ref_id'        => $obat->id,
        ]);

        return redirect()->route('obat.index')->with('success', 'Data obat berhasil disimpan.');
    }
    // // Menampilkan log mutasi obat
    // public function mutasi()
    // {
    //     $logObat = LogObat::with('obat')->orderBy('tgl_transaksi', 'desc')->get();
    //     return view('paramedis.mutasi_obat', compact('logObat'));
    // }
}
