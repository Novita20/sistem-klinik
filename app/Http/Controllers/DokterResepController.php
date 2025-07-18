<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\ResepObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DokterResepController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $reseps = ResepObat::with(['obat', 'rekamMedis.kunjungan.pasien.user'])
            ->where(function ($query) use ($search) {
                $query->whereHas('rekamMedis.kunjungan.pasien.user', function ($q) use ($search) {
                    if ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    }
                });

                $query->orWhereHas('obat', function ($q) use ($search) {
                    if ($search) {
                        $q->where('nama_obat', 'like', '%' . $search . '%');
                    }
                });
            })
            ->orderByDesc('created_at')
            ->paginate(10); // Ubah jumlah per halaman sesuai kebutuhan

        return view('dokter.resep.index', compact('reseps', 'search'));
    }
    public function search(Request $request)
    {
        $query = $request->input('q');
        $results = Obat::where('nama_obat', 'like', "%{$query}%")->limit(10)->get(['id', 'nama_obat', 'stok']);
        return response()->json($results);
    }
    public function formItem()
    {
        $obats = Obat::all(); // ambil semua obat
        return view('dokter.resep._form_item', compact('obat'));
    }


    public function autocomplete(Request $request)
    {
        $term = $request->q;

        $data = \App\Models\Obat::where('nama_obat', 'like', "%$term%")
            ->select('id', 'nama_obat')
            ->limit(10)
            ->get();

        return response()->json($data);
    }


    // 🧾 Form input resep oleh dokter
    public function create($rekam_medis_id)
    {
        $rekamMedis = RekamMedis::with('kunjungan.pasien.user')->findOrFail($rekam_medis_id);
        $obats = Obat::all();

        return view('dokter.resep.create', compact('rekamMedis', 'obats'));
    }
    public function storeMultiple(Request $request)
    {
        $request->validate([
            'rekam_medis_id' => 'required|exists:rekam_medis,id',
            'obat_id' => 'required|array|min:1',
            'obat_id.*' => 'exists:obat,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
            'dosis' => 'nullable|array',
            'dosis.*' => 'nullable|string|max:255',
            'aturan_pakai' => 'nullable|array',
            'aturan_pakai.*' => 'nullable|string|max:255',
        ]);


        $rekamMedis = RekamMedis::with('kunjungan')->findOrFail($request->rekam_medis_id);
        $pasienId = $rekamMedis->kunjungan->pasien_id;

        foreach ($request->obat_id as $index => $obatId) {
            ResepObat::create([
                'rekam_medis_id' => $request->rekam_medis_id,
                'obat_id' => $obatId,
                'jumlah' => $request->jumlah[$index],
                'dosis' => $request->dosis[$index] ?? null,
                'aturan_pakai' => $request->aturan_pakai[$index] ?? null,
                'pasien_id' => $rekamMedis->kunjungan->pasien_id,
            ]);
        }

        // Tandai kunjungan sebagai selesai
        $rekamMedis->kunjungan->update(['status' => 'selesai']);

        return redirect()->route('dokter.kunjungan.detail', $rekamMedis->kunjungan->id)
            ->with('success', 'Beberapa resep berhasil disimpan dan kunjungan selesai.');
    }


    // 💾 Simpan resep baru oleh dokter
    public function store(Request $request)
    {
        Log::info('Memulai store resep', $request->all());

        $request->validate([
            'rekam_medis_id' => 'required|exists:rekam_medis,id',
            'obat_id'        => 'required|exists:obat,id',
            'jumlah'         => 'required|integer|min:1',
            'dosis'          => 'nullable|string|max:255',         // ✅ GANTI dari 'keterangan'
            'aturan_pakai'   => 'nullable|string|max:255',         // ✅ TAMBAHAN baru
        ]);

        Log::info('Validasi sukses');

        $rekamMedis = RekamMedis::with('kunjungan')->findOrFail($request->rekam_medis_id);
        $pasienId = $rekamMedis->kunjungan->pasien_id;

        ResepObat::create([
            'rekam_medis_id' => $rekamMedis->id,
            'obat_id'        => $request->obat_id,
            'jumlah'         => $request->jumlah,
            'dosis'          => $request->dosis,
            'aturan_pakai'   => $request->aturan_pakai,
            'pasien_id'      => $pasienId,
        ]);

        Log::info('Resep berhasil disimpan');

        $kunjungan = $rekamMedis->kunjungan;
        $kunjungan->status = 'selesai';
        $kunjungan->save();

        Log::info('Status kunjungan diubah menjadi selesai');

        return redirect()->route('dokter.kunjungan.detail', $kunjungan->id)
            ->with('success', 'Resep berhasil disimpan dan kunjungan selesai.');
    }
    public function edit($id)
    {
        $resep = ResepObat::findOrFail($id);
        $obat = Obat::all(); // Jika kamu perlu dropdown pilihan obat
        return view('dokter.resep.edit', compact('resep', 'obat'));
    }

    public function destroy($id)
    {
        ResepObat::destroy($id);
        return redirect()->route('dokter.resep')->with('success', 'Resep berhasil dihapus.');
    }
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'obat_id' => 'required|exists:obat,id',
            'jumlah' => 'required|integer|min:1',
            'dosis' => 'nullable|string|max:255',
            'aturan_pakai' => 'nullable|string|max:255',
        ]);

        // Ambil data resep berdasarkan ID
        $resep = ResepObat::findOrFail($id);

        // Update data resep
        $resep->update([
            'obat_id' => $request->obat_id,
            'jumlah' => $request->jumlah,
            'dosis' => $request->dosis,
            'aturan_pakai' => $request->aturan_pakai,
        ]);

        // Redirect kembali ke halaman index dengan flash message
        return redirect()->route('dokter.resep')->with('success', 'Resep berhasil diperbarui.');
    }
}
