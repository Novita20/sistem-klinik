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
        $search = $request->input('search');

        $obats = Obat::query()
            ->when($search, function ($query) use ($search) {
                $query->where('nama_obat', 'like', '%' . $search . '%');
            })
            ->orderBy('nama_obat')
            ->paginate(10)
            ->appends(['search' => $search]);

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

        $obat = Obat::create($request->all());

        LogObat::create([
            'obat_id' => $obat->id,
            'jenis_mutasi' => 'masuk',
            'jumlah' => $obat->stok,
            'stok_awal' => $obat->stok,
            'sisa_stok' => $obat->stok,
            'tgl_transaksi' => now(),
            'expired_at' => $obat->expired_at, // ✅ pastikan ini kolomnya benar
            'keterangan' => 'Input awal obat',
            'ref_type' => 'obat',
            'ref_id' => $obat->id,
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
        $request->validate([
            'nama_obat'   => 'required|string|max:255',
            'jenis_obat'  => 'required|string|max:255',
            'stok'        => 'required|integer|min:0',
            'satuan'      => 'required|string|max:50',
            'expired_at'  => 'required|date',
        ]);

        $obat = Obat::findOrFail($id);
        $stokLama = $obat->stok;

        $obat->update($request->only(['nama_obat', 'jenis_obat', 'stok', 'satuan', 'expired_at']));

        if ($stokLama !== $request->stok) {
            LogObat::create([
                'obat_id' => $obat->id,
                'jenis_mutasi' => $request->stok > $stokLama ? 'masuk' : 'keluar',
                'jumlah' => abs($request->stok - $stokLama),
                'stok_awal' => $stokLama,
                'sisa_stok' => $request->stok,
                'tgl_transaksi' => now(),
                'expired_at' => $obat->expired_at, // ✅ gunakan dari $obat
                'keterangan' => 'Penyesuaian stok saat edit',
                'ref_type' => 'obat',
                'ref_id' => $obat->id,
            ]);
        }

        return redirect()->route('obat.index')->with('success', 'Data obat berhasil diperbarui.');
    }

    // public function indexResep()
    // {
    //     dd('masuk sini');

    //     $resepObat = ResepObat::with([
    //         'rekamMedis.kunjungan.user.pasien',
    //         'obat'
    //     ])->latest()->get();

    //     return view('paramedis.resep.index', compact('resepObat'));
    // }


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



    public function editLog($id)
    {
        $log = LogObat::with('obat')->findOrFail($id);
        return view('paramedis.mutasi.edit', compact('log'));
    }
    public function updateLog(Request $request, $id)
    {
        $request->validate([
            'jenis_mutasi'  => 'required|in:masuk,keluar',
            'jumlah'        => 'required|integer|min:0',
            'stok_awal'     => 'required|integer|min:0',
            'sisa_stok'     => 'required|integer|min:0',
            'tgl_transaksi' => 'required|date',
            'expired_at'    => 'nullable|date',
            'keterangan'    => 'nullable|string',
        ]);

        $log = LogObat::findOrFail($id);

        $log->update([
            'jenis_mutasi'  => $request->jenis_mutasi,
            'jumlah'        => $request->jumlah,
            'stok_awal'     => $request->stok_awal,
            'sisa_stok'     => $request->sisa_stok,
            'tgl_transaksi' => $request->tgl_transaksi,
            'expired_at'    => $request->expired_at,
            'keterangan'    => $request->keterangan,
        ]);

        return redirect()->route('obat.mutasi')->with('success', 'Mutasi obat berhasil diperbarui.');
    }
}
