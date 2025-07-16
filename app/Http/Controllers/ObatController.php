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

        $obats = Obat::with('logObat') // Eager load log_obat
            ->when($search, function ($query) use ($search) {
                $query->where('nama_obat', 'like', '%' . $search . '%');
            })
            ->orderBy('nama_obat')
            ->get();

        // ✅ Hitung stok dinamis dari log_obat
        $obats = $obats->map(function ($obat) {
            $masuk = $obat->logObat->where('jenis_mutasi', 'masuk')->sum('jumlah');
            $keluar = $obat->logObat->where('jenis_mutasi', 'keluar')->sum('jumlah');
            $obat->total_stok = $masuk - $keluar;
            $obat->jumlah_batch = $obat->logObat->count();
            return $obat;
        });

        return view('paramedis.obat.index', compact('obats', 'search'));
    }



    public function showDetail($id)
    {
        $obat = Obat::with('logObat')->findOrFail($id);
        return view('paramedis.obat.detail', compact('obat'));
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
            'id_obat'     => 'required|exists:obat,id',
            'stok'        => 'required|integer|min:0',
            'expired_at'  => 'required|date',
        ]);

        $obat = Obat::findOrFail($request->id_obat);

        // Ambil stok terakhir dari batch dengan expired_at yang sama
        $stokSebelumnya = LogObat::where('obat_id', $obat->id)
            ->where('expired_at', $request->expired_at)
            ->orderByDesc('tgl_transaksi')
            ->first();

        $stokAwal = $stokSebelumnya ? $stokSebelumnya->sisa_stok : 0;
        $sisaStokBaru = $stokAwal + $request->stok;

        // ✅ Simpan log mutasi masuk
        LogObat::create([
            'obat_id'       => $obat->id,
            'jenis_mutasi'  => 'masuk',
            'jumlah'        => $request->stok,
            'stok_awal'     => $stokAwal,
            'sisa_stok'     => $sisaStokBaru,
            'expired_at'    => $request->expired_at,
            'tgl_transaksi' => now(),
            'keterangan'    => 'Penambahan stok dari form input',
            'ref_type'      => 'obat',
            'ref_id'        => $obat->id,
        ]);

        // ✅ Hitung ulang total stok dari seluruh batch mutasi masuk - keluar
        $stokMasuk = LogObat::where('obat_id', $obat->id)
            ->where('jenis_mutasi', 'masuk')
            ->sum('jumlah');

        $stokKeluar = LogObat::where('obat_id', $obat->id)
            ->where('jenis_mutasi', 'keluar')
            ->sum('jumlah');

        $stokFinal = $stokMasuk - $stokKeluar;

        // ✅ Update kolom `obat.stok` sesuai hasil total log
        $obat->update([
            'stok'       => max(0, $stokFinal),
            'expired_at' => $request->expired_at, // opsional: bisa dikosongkan jika tiap batch berbeda
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_obat'   => 'required|string|max:255',
            // 'jenis_obat'  => 'required|string|max:255',
            'stok'        => 'required|integer|min:0',
            // 'satuan'      => 'required|string|max:50',
            'expired_at'  => 'required|date',
        ]);

        $obat = Obat::findOrFail($id);
        $stokLama = $obat->stok;
        $stokBaru = $request->stok;

        // ✅ Update data
        $obat->update($request->only([
            'nama_obat',
            // 'jenis_obat',
            'stok',
            // 'satuan',
            'expired_at'
        ]));

        // ✅ Catat mutasi stok jika berubah
        if ($stokLama !== $stokBaru) {
            $jenisMutasi = $stokBaru > $stokLama ? 'masuk' : 'keluar';
            $jumlahMutasi = abs($stokBaru - $stokLama);

            LogObat::create([
                'obat_id'       => $obat->id,
                'jenis_mutasi'  => $jenisMutasi,
                'jumlah'        => $jumlahMutasi,
                'stok_awal'     => $stokLama,
                'sisa_stok'     => $stokBaru,
                'tgl_transaksi' => now()->timezone('Asia/Jakarta'),
                'keterangan'    => 'Penyesuaian stok saat edit',
                'ref_type'      => 'obat',
                'ref_id'        => $obat->id,
            ]);
        }

        return redirect()->route('obat.index')->with('success', '✅ Data obat berhasil diperbarui.');
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

    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);

        // Hapus relasi batch terlebih dahulu, misal log_obat
        $obat->logObat()->delete();

        // Hapus master obat
        $obat->delete();

        return redirect()->route('obat.index')->with('success', 'Obat berhasil dihapus beserta seluruh batch-nya.');
    }
}
