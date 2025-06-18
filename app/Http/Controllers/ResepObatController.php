<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\ResepObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResepObatController extends Controller
{
    // 🧾 Paramedis: Tampilkan form input resep
    public function create()
    {
        $rekamMedis = RekamMedis::with('pasien')->get();
        $obats = Obat::all();

        return view('paramedis.create_resep', compact('rekamMedis', 'obats'));
    }

    // 👩‍⚕️ Pasien: Melihat resep obat miliknya
    public function index()
    {
        $user = Auth::user();
        $pasien = Pasien::where('user_id', $user->id)->first();

        if ($pasien) {
            $reseps = ResepObat::where('pasien_id', $pasien->id)->get();
        } else {
            $reseps = collect(); // Koleksi kosong agar tidak error di blade
        }

        return view('pasien.resep', compact('reseps'));
    }

    // 💾 Paramedis: Simpan resep baru
    public function store(Request $request)
    {
        $request->validate([
            'rekam_medis_id' => 'required|exists:rekam_medis,id',
            'obat_id' => 'required|exists:obat,id',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        // Kurangi stok obat
        $obat = Obat::findOrFail($request->obat_id);
        if ($request->jumlah > $obat->stok) {
            return back()->withErrors(['jumlah' => 'Jumlah melebihi stok obat']);
        }
        $obat->stok -= $request->jumlah;
        $obat->save();

        // Ambil pasien_id dari rekam medis
        $rekamMedis = RekamMedis::findOrFail($request->rekam_medis_id);
        $pasienId = $rekamMedis->pasien_id;

        // Simpan resep
        ResepObat::create([
            'rekam_medis_id' => $request->rekam_medis_id,
            'obat_id' => $request->obat_id,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'pasien_id' => $pasienId, // tambahkan pasien_id di sini
        ]);

        return back()->with('success', 'Resep berhasil disimpan');
    }
}
