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

        // 🔍 Ambil semua log obat + relasi obat & resep
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
            ->orderBy('tgl_transaksi')
            ->orderBy('id') // untuk menghindari duplikasi data di tanggal sama
            ->get();

        // ✅ Hitung stok awal dan sisa stok per obat (global, tidak per expired_at)
        $stokTotalPerObat = [];

        foreach ($logObat as $log) {
            $obatId = $log->obat_id;

            // Inisialisasi jika belum ada
            if (!isset($stokTotalPerObat[$obatId])) {
                $stokTotalPerObat[$obatId] = 0;
            }

            // Hitung stok_awal berdasarkan total stok sebelum transaksi ini
            $log->stok_awal = $stokTotalPerObat[$obatId];

            // Hitung sisa stok setelah transaksi
            if ($log->jenis_mutasi === 'masuk') {
                $stokTotalPerObat[$obatId] += $log->jumlah;
            } elseif ($log->jenis_mutasi === 'keluar') {
                $stokTotalPerObat[$obatId] -= $log->jumlah;
            }

            $log->sisa_stok = max(0, $stokTotalPerObat[$obatId]); // Tidak boleh negatif
        }

        // ✅ Pagination manual (karena data sudah get)
        $page = $request->input('page', 1);
        $perPage = 10;
        $paged = $logObat->forPage($page, $perPage);
        $logObatPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $paged,
            $logObat->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('paramedis.mutasi.index', [
            'logObat' => $logObatPaginated
        ]);
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
            'jumlah'        => 'required|numeric|min:1',
            'expired_at'    => 'nullable|date',
        ]);

        $log = new LogObat();
        $log->obat_id       = $request->obat_id;
        $log->jenis_mutasi  = $request->jenis_mutasi;
        $log->jumlah        = $request->jumlah;
        $log->expired_at    = $request->expired_at;
        $log->keterangan    = $request->keterangan;
        $log->tgl_transaksi = now();
        $log->ref_type      = 'obat';
        $log->ref_id        = $request->obat_id;

        // Ambil stok terakhir dari batch dengan expired_at yang sama
        $stokSebelumnya = LogObat::where('obat_id', $request->obat_id)
            ->where('expired_at', $request->expired_at)
            ->orderByDesc('tgl_transaksi')
            ->first();

        $stokAwal = $stokSebelumnya ? $stokSebelumnya->sisa_stok : 0;
        $log->stok_awal = $stokAwal;

        if ($request->jenis_mutasi === 'masuk') {
            $log->sisa_stok = $stokAwal + $request->jumlah;
        } else {
            // Validasi tambahan agar tidak negatif
            if ($stokAwal < $request->jumlah) {
                return back()->withErrors(['jumlah' => 'Stok tidak mencukupi untuk mutasi keluar.'])->withInput();
            }

            $log->sisa_stok = $stokAwal - $request->jumlah;
        }

        $log->save();

        return redirect()->route('logobat.mutasi')->with('success', 'Mutasi obat berhasil dicatat.');
    }
}
