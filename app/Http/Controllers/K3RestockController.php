<?php

namespace App\Http\Controllers;

use App\Models\RestockObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class K3RestockController extends Controller
{
    public function index()
    {
        $pengajuan = RestockObat::with('obat', 'requestedBy')
            ->where('status', 'menunggu')
            ->get();
        return view('k3.restock', compact('pengajuan'));
    }
    public function setujui($id)
    {
        $pengajuan = RestockObat::findOrFail($id);
        $pengajuan->status = 'disetujui';
        $pengajuan->approved_by = Auth::id();
        $pengajuan->save();

        return redirect()->back()->with('success', 'Pengajuan telah disetujui.');
    }

    public function tolak($id)
    {
        $pengajuan = RestockObat::findOrFail($id);
        $pengajuan->status = 'ditolak';
        $pengajuan->approved_by = Auth::id();
        $pengajuan->save();

        return redirect()->back()->with('success', 'Pengajuan telah ditolak.');
    }

    public function laporan()
    {
        $pengajuan = RestockObat::with('obat', 'requestedBy', 'approvedBy')
            ->where('status', 'disetujui') // hanya tampilkan yang disetujui
            ->latest()
            ->get();
        return view('k3.laporan_obat', compact('pengajuan'));
    }
}
