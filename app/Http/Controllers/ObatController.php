<?php

namespace App\Http\Controllers;

use App\Models\LogObat;
use App\Models\Obat;
use App\Models\ResepObat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    // Menampilkan semua data obat + search & pagination
    // Tampilkan halaman list obat
    public function index(Request $request)
    {
        $search = $request->input('search'); // Ambil nilai search dari request

        $obats = Obat::query()
            ->when($search, function ($query) use ($search) {
                $query->where('nama_obat', 'like', '%' . $search . '%');
            })
            ->orderBy('nama_obat')
            ->paginate(10)
            ->appends(['search' => $search]); // Agar search tetap saat klik pagination

        return view('paramedis.obat.index', compact('obats', 'search'));
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
    // Tampilkan form edit
    public function edit($id)
    {
        $obat = Obat::findOrFail($id);
        return view('paramedis.obat.edit', compact('obat'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'nama_obat'   => 'required|string|max:255',
            'jenis_obat'  => 'required|string|max:255',
            'stok'        => 'required|integer|min:0',
            'satuan'      => 'required|string|max:50',
            'expired_at'  => 'required|date',
        ]);

        $obat = Obat::findOrFail($id);

        // HANYA update field yang diizinkan
        $obat->update([
            'nama_obat'   => $request->nama_obat,
            'jenis_obat'  => $request->jenis_obat,
            'stok'        => $request->stok,
            'satuan'      => $request->satuan,
            'expired_at'  => $request->expired_at,
        ]);

        return redirect()->route('obat.index')->with('success', 'Data obat berhasil diperbarui.');
    }
    public function indexResep()
    {
        dd('masuk sini');

        $resepObat = ResepObat::with([
            'rekamMedis.kunjungan.user.pasien',
            'obat'
        ])->latest()->get();

        return view('paramedis.resep.index', compact('resepObat'));
    }


    public function berikanObat($id)
    {
        $resep = ResepObat::findOrFail($id);
        $resep->status_diberikan = true;
        $resep->save();

        return redirect()->route('paramedis.resep.index')->with('success', 'Obat berhasil diberikan ke pasien.');
    }
}
