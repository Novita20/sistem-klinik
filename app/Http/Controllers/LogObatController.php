<?php

namespace App\Http\Controllers;

use App\Models\LogObat;
use Illuminate\Http\Request;

class LogObatController extends Controller
{


    // 🔍 Menampilkan semua log mutasi obat (obat + resep yang diberikan)
    public function mutasi(Request $request)
    {
        $search = $request->input('search');

        $logObat = LogObat::with(['obat', 'resep'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('obat', function ($q) use ($search) {
                    $q->where('nama_obat', 'like', '%' . $search . '%');
                });
            })
            ->where(function ($q) {
                $q->where('ref_type', 'obat')
                    ->orWhere(function ($q2) {
                        $q2->where('ref_type', 'resep')
                            ->whereIn('ref_id', function ($subQuery) {
                                $subQuery->select('id')
                                    ->from('resep_obat')
                                    ->where('status_diberikan', true);
                            });
                    });
            })
            ->orderByDesc('tgl_transaksi')
            ->paginate(10);

        return view('paramedis.mutasi.index', compact('logObat'));
    }

    // ✏️ Menampilkan form edit mutasi
    public function editLog($id)
    {
        $log = LogObat::with('obat')->findOrFail($id);
        return view('paramedis.mutasi.edit', compact('log'));
    }

    // 💾 Menyimpan perubahan data log mutasi
    public function updateLog(Request $request, $id)
    {
        $request->validate([
            'jenis_mutasi'  => 'required|in:masuk,keluar',
            'jumlah'        => 'required|integer|min:1',
            'stok_awal'     => 'required|integer|min:0',
            'sisa_stok'     => 'required|integer|min:0',
            'tgl_transaksi' => 'required|date',
            'expired_at'    => 'nullable|date',
            'keterangan'    => 'nullable|string|max:255',
        ]);

        $log = LogObat::findOrFail($id);

        $log->update([
            'jenis_mutasi'  => $request->jenis_mutasi,
            'jumlah'        => $request->jumlah,
            'stok_awal'     => $request->stok_awal,
            'sisa_stok'     => $request->sisa_stok,
            'tgl_transaksi' => $request->tgl_transaksi,
            // 'expired_at'    => $request->expired_at,
            'keterangan'    => $request->keterangan,
        ]);

        return redirect()->route('logobat.mutasi')->with('success', 'Mutasi obat berhasil diperbarui.');
    }

    public function storeLog(Request $request)
    {
        $request->validate([
            'obat_id'       => 'required|exists:obat,id',
            'jenis_mutasi'  => 'required|in:masuk,keluar',
            'jumlah'        => 'required|integer|min:1',
            'tgl_transaksi' => 'required|date',
            'expired_at'    => 'nullable|date',
            'keterangan'    => 'nullable|string|max:255',
        ]);

        $obat = \App\Models\Obat::findOrFail($request->obat_id);
        $stok_awal = $obat->stok;

        // hitung stok setelah mutasi
        $sisa_stok = $request->jenis_mutasi === 'masuk'
            ? $stok_awal + $request->jumlah
            : $stok_awal - $request->jumlah;

        // buat log
        LogObat::create([
            'obat_id'       => $obat->id,
            'jenis_mutasi'  => $request->jenis_mutasi,
            'jumlah'        => $request->jumlah,
            'stok_awal'     => $stok_awal,
            'sisa_stok'     => $sisa_stok,
            'tgl_transaksi' => $request->tgl_transaksi,
            'expired_at'    => $request->expired_at,
            'keterangan'    => $request->keterangan,
            'ref_type'      => 'manual',
            'ref_id'        => null,
        ]);

        // update stok di tabel obat
        $obat->update(['stok' => $sisa_stok]);

        return redirect()->route('logobat.mutasi')->with('success', 'Mutasi berhasil ditambahkan.');
    }
}
