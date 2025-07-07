<?php

namespace App\Http\Controllers;

use App\Models\LogObat;
use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    // ✅ Tampilkan daftar obat dengan pencarian
    public function index(Request $request)
    {
        $search = $request->input('search');

        $obats = Obat::query()
            ->when(
                $search,
                fn($query) =>
                $query->where('nama_obat', 'like', '%' . $search . '%')
            )
            ->orderBy('nama_obat')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('paramedis.obat.index', compact('obats', 'search'));
    }

    // ✅ Tampilkan form tambah obat
    public function create()
    {
        $obats = Obat::orderBy('nama_obat')->get(); // ambil semua nama obat
        $jenis_obats = Obat::select('jenis_obat')->distinct()->orderBy('jenis_obat')->pluck('jenis_obat');
        return view('paramedis.obat.create', compact('obats', 'jenis_obats'));
    }


    // ✅ Simpan obat baru & log stok awal (mutasi masuk)
    public function store(Request $request)
    {
        $request->validate([
            'id_obat'      => 'required|exists:obat,id',
            'jenis_obat'  => 'required|string|max:255',
            'stok'        => 'required|integer|min:0',
            'satuan'      => 'required|string|max:50',
            'expired_at'  => 'required|date',
        ]);

        $obat = Obat::findOrFail($request->id_obat);

        $stokLama = $obat->stok;
        $stokBaru = $stokLama + $request->stok;

        // Update stok dan expired jika perlu
        $obat->update([
            'stok'       => $stokBaru,
            'jenis_obat' => $request->jenis_obat,
            'satuan'     => $request->satuan,
            'expired_at' => $request->expired_at,
        ]);

        LogObat::create([
            'obat_id'       => $obat->id,
            'jenis_mutasi'  => 'masuk',
            'jumlah'        => $request->stok,
            'stok_awal'     => $stokLama,
            'sisa_stok'     => $stokBaru,
            'tgl_transaksi' => now(),
            'keterangan'    => 'Penambahan stok dari form input',
            'ref_type'      => 'obat',
            'ref_id'        => $obat->id,
        ]);

        return redirect()->route('obat.index')->with('success', 'Data obat berhasil disimpan.');
    }

    // ✅ Tampilkan form edit
    public function edit($id)
    {
        $obat = Obat::findOrFail($id);
        $jenis_obats = Obat::select('jenis_obat')->distinct()->orderBy('jenis_obat')->pluck('jenis_obat');
        return view('paramedis.obat.edit', compact('obat', 'jenis_obats'));
    }

    // ✅ Update data obat & catat mutasi jika stok berubah
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_obat'   => 'required|string|max:255',
            'jenis_obat'  => 'required|string|max:255',
            'stok'        => 'required|integer|min:0',
            'satuan'      => 'required|string|max:50',
            'expired_at'  => 'required|date',
        ]);

        $obat = Obat::findOrFail($id);
        $stokLama = $obat->stok;
        $stokBaru = $request->stok;

        $obat->update($request->only([
            'nama_obat',
            'jenis_obat',
            'stok',
            'satuan',
            'expired_at'
        ]));

        // Catat log jika stok berubah
        if ($stokLama !== $stokBaru) {
            $jenisMutasi = $stokBaru > $stokLama ? 'masuk' : 'keluar';
            $jumlahMutasi = abs($stokBaru - $stokLama);

            LogObat::create([
                'obat_id'       => $obat->id,
                'jenis_mutasi'  => $jenisMutasi,
                'jumlah'        => $jumlahMutasi,
                'stok_awal'     => $stokLama,
                'sisa_stok'     => $stokBaru,
                'tgl_transaksi' => now(),
                // 'expired_at' => $obat->expired_at, // aktifkan jika tersedia
                'keterangan'    => 'Penyesuaian stok saat edit',
                'ref_type'      => 'obat',
                'ref_id'        => $obat->id,
            ]);
        }

        return redirect()->route('obat.index')->with('success', 'Data obat berhasil diperbarui.');
    }
    public function formObatBaru()
    {
        return view('paramedis.obat.baru'); // asumsi file view-nya adalah create.blade.php
    }
    public function storeObatBaru(Request $request)
    {
        $request->validate([
            'nama_obat'   => 'required|string|max:255|unique:obat,nama_obat',
            'jenis_obat'  => 'required|string|max:255',
            'stok'        => 'required|integer|min:0',
            'satuan'      => 'required|string|max:50',
            'expired_at'  => 'required|date',
        ]);

        $obat = Obat::create([
            'nama_obat'   => $request->nama_obat,
            'jenis_obat'  => $request->jenis_obat,
            'stok'        => $request->stok,
            'satuan'      => $request->satuan,
            'expired_at'  => $request->expired_at,
        ]);

        LogObat::create([
            'obat_id'       => $obat->id,
            'jenis_mutasi'  => 'masuk',
            'jumlah'        => $request->stok,
            'stok_awal'     => 0,
            'sisa_stok'     => $request->stok,
            'tgl_transaksi' => now(),
            'keterangan'    => 'Obat baru ditambahkan',
            'ref_type'      => 'obat',
            'ref_id'        => $obat->id,
        ]);

        return redirect()->route('obat.index')->with('success', 'Obat baru berhasil ditambahkan.');
    }
}
