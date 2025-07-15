<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\LogObat;

class StokObatController extends Controller
{
    public function create()
    {
        $obats = Obat::all();
        return view('paramedis.obat.batch', compact('obats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'obat_id'       => 'required|exists:obat,id',
            'stok'          => 'required|numeric|min:1',
            'tgl_transaksi' => 'required|date',
            'expired_at'    => 'required|date|after_or_equal:tgl_transaksi',
        ]);

        $obat = Obat::findOrFail($request->obat_id);

        // Optional: Ambil stok sebelumnya kalau pakai log stok_awal
        $stokAwal = $obat->stok ?? 0;
        $stokBaru = $stokAwal + $request->stok;

        // Simpan ke tabel log_obat
        LogObat::create([
            'obat_id'       => $request->obat_id,
            'jumlah'        => $request->stok,
            'stok_awal'     => $stokAwal,
            'sisa_stok'     => $stokBaru,
            'jenis_mutasi'  => 'masuk',
            'tgl_transaksi' => $request->tgl_transaksi,
            'expired_at'    => $request->expired_at,
            'keterangan'    => 'Penambahan stok obat',
            'ref_type'      => 'obat',
            'ref_id'        => $request->obat_id,
        ]);

        return redirect()->route('obat.index')->with('success', '✅ Stok obat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $logObat = LogObat::with('obat')->findOrFail($id);
        return view('paramedis.obat.edit', compact('logObat'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah'        => 'required|integer|min:1',
            'tgl_transaksi' => 'required|date',
            'expired_at'    => 'required|date',
        ]);

        $logObat = LogObat::with('obat')->findOrFail($id);

        // Update data log
        $logObat->update([
            'jumlah'        => $request->jumlah,
            'tgl_transaksi' => $request->tgl_transaksi,
            'expired_at'    => $request->expired_at,
        ]);

        return redirect()->route('obat.detail', $logObat->obat_id)->with('success', '✅ Batch berhasil diperbarui.');
    }
}
