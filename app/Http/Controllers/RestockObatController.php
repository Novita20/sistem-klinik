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
            ->orderBy('created_at', 'desc')
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
            'obat_id' => 'required|exists:obat,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pengajuan' => 'required|date',
        ]);

        RestockObat::create([
            'obat_id' => $request->obat_id,
            'jumlah' => $request->jumlah,
            'status' => 'diajukan',
            'tanggal_pengajuan' => Carbon::createFromFormat('Y-m-d\TH:i', $request->tanggal_pengajuan, 'Asia/Jakarta')->setTimezone('UTC'),

        ]);

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
