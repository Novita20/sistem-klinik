<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\RestockObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RestockObatController extends Controller
{
    /**
     * Paramedis - Menampilkan daftar pengajuan restock (tanpa requested_by)
     */
    public function index()
    {
        $pengajuan = RestockObat::with('obat')
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get();
        return view('paramedis.restock.index', compact('pengajuan'));
    }

    /**
     * Paramedis - Menampilkan form pengajuan restock obat
     */
    public function create()
    {
        $obat = Obat::orderBy('nama_obat')->get();

        return view('paramedis.restock.create', compact('obat'));
    }

    /**
     * Paramedis - Menyimpan pengajuan restock
     */
    public function store(Request $request)
    {
        $request->validate([
            'obat_id' => 'required|array',
            'obat_id.*' => 'exists:obat,id',
            'jumlah' => 'required|array',
            'jumlah.*' => 'integer|min:1',
            'tanggal_pengajuan' => 'required|date',
        ]);

        // Simpan semua pengajuan
        foreach ($request->obat_id as $index => $obatId) {
            RestockObat::create([
                'obat_id' => $obatId,
                'jumlah' => $request->jumlah[$index],
                'status' => 'diajukan',
                'tanggal_pengajuan' => $request->tanggal_pengajuan,
            ]);
        }

        // PENTING: redirect HARUS DILUAR foreach
        return redirect()->route('paramedis.restock.index')
            ->with('success', 'Pengajuan berhasil dikirim ke K3.');
    }


    /**
     * K3 - Menampilkan daftar pengajuan yang masuk untuk disetujui
     */
    public function approvalIndex()
    {
        $pengajuan = RestockObat::with('obat')
            ->where('status', 'diajukan')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('k3.restock.index', compact('pengajuan'));
    }

    /**
     * K3 - Menyetujui atau menolak pengajuan restock
     */
    public function approve(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
        ]);

        $restock = RestockObat::findOrFail($id);
        $restock->update([
            'status' => $request->status,
        ]);

        return redirect()->route('k3.restock.index')
            ->with('success', 'Status pengajuan berhasil diperbarui.');
    }
}
