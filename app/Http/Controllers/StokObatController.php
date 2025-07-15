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
            'obat_id' => 'required|exists:obat,id',
            'stok' => 'required|numeric|min:1',
            'tgl_transaksi' => 'required|date',
            'expired_at' => 'required|date|after_or_equal:tgl_transaksi',
        ]);

        LogObat::create([
            'obat_id' => $request->obat_id,
            'stok' => $request->stok,
            'tgl_transaksi' => $request->tgl_transaksi,
            'expired_at' => $request->expired_at,
        ]);

        return redirect()->route('obat.index')->with('success', 'Stok obat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Pastikan relasi 'obat' sudah didefinisikan di model LogObat
        $logObat = LogObat::with('obat')->findOrFail($id);

        return view('paramedis.obat.edit', compact('logObat'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:0',
            'expired_at' => 'required|date',
        ]);

        $logObat = LogObat::with('obat')->findOrFail($id);

        // ✅ Update hanya kolom yang memang ada di tabel log_obat
        $logObat->update([
            'jumlah'        => $request->jumlah,
            'tgl_transaksi' => now(),
        ]);

        // ✅ Update expired_at ke tabel obat (karena expired_at ada di tabel obat, bukan log_obat)
        $logObat->obat->update([
            'expired_at' => $request->expired_at,
        ]);

        return redirect()->route('obat.detail', $logObat->obat->id)
            ->with('success', '✅ Data batch berhasil diperbarui.');
    }
}
