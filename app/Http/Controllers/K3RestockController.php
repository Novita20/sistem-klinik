<?php

namespace App\Http\Controllers;

use App\Models\RestockObat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanObatK3Export;
use App\Models\ResepObat;


class K3RestockController extends Controller
{
    /**
     * Tampilkan daftar pengajuan restock obat yang masih menunggu persetujuan.
     */
    public function index(Request $request)
    {
        $status = $request->input('status');
        $search = $request->input('search');

        $pengajuan = RestockObat::with(['obat', 'requestedBy'])
            ->when($status, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('obat', function ($q) use ($search) {
                    $q->where('nama_obat', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString(); // agar status & search tetap di query URL

        return view('k3.restock', compact('pengajuan', 'status', 'search'));
    }


    /**
     * Setujui pengajuan restock obat.
     */
    public function setujui($id)
    {
        $pengajuan = RestockObat::findOrFail($id);
        $pengajuan->update([
            'status' => 'disetujui',
            'approved_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Pengajuan telah disetujui.');
    }

    /**
     * Tolak pengajuan restock obat.
     */
    public function tolak($id)
    {
        $pengajuan = RestockObat::findOrFail($id);
        $pengajuan->update([
            'status' => 'ditolak',
            'approved_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Pengajuan telah ditolak.');
    }

    /**
     * Tampilkan laporan restock obat yang telah disetujui.
     */
    public function laporan(Request $request)
    {
        // Ambil input dari form
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $search = $request->search;

        // 🛠️ Atur default tanggal jika kosong
        if (!$startDate) {
            $startDate = '2000-01-01'; // Tanggal awal default
        }

        if (!$endDate) {
            $endDate = now()->toDateString(); // Tanggal akhir default: hari ini
        }

        // 🔍 Query dengan filter yang sudah diperbaiki
        $resep = ResepObat::with('obat')
            ->where('status_diberikan', 1)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->when(
                $search,
                fn($query) =>
                $query->whereHas(
                    'obat',
                    fn($q) =>
                    $q->where('nama_obat', 'like', '%' . $search . '%')
                )
            )
            ->get();

        // 🔁 Grupkan dan olah data
        $data = $resep->groupBy('obat_id')->map(function ($group) {
            return [
                'nama_obat' => $group->first()->obat->nama_obat ?? '-',
                'frekuensi' => $group->count(),
                'terakhir_digunakan' => $group->sortByDesc('created_at')->first()->created_at,
            ];
        })->values();

        // Kirim ke view
        return view('k3.laporan_obat', compact('data'));
    }




    public function export(Request $request)
    {
        $startDate = $request->input('start_date') ?? '2000-01-01';
        $endDate = $request->input('end_date') ?? now()->toDateString();
        $search = $request->input('search');

        // Ambil data resep obat yang telah diberikan
        $reseps = ResepObat::with('obat')
            ->where('status_diberikan', 1)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('obat', function ($q) use ($search) {
                    $q->where('nama_obat', 'like', '%' . $search . '%');
                });
            })
            ->get();

        // Proses rekap (group by obat_id)
        $data = $reseps->groupBy('obat_id')->map(function ($group) {
            return [
                'nama_obat' => $group->first()->obat->nama_obat ?? '-',
                'frekuensi' => $group->count(),
                'terakhir_digunakan' => optional($group->sortByDesc('created_at')->first()->created_at)->format('d-m-Y'),
            ];
        })->values()->toArray();

        // Kirim ke export
        return Excel::download(
            new LaporanObatK3Export($startDate, $endDate, $search),
            'laporan_penggunaan_obat_k3.xlsx'
        );
    }


    public function destroy($id)
    {
        $pengajuan = RestockObat::findOrFail($id);
        $pengajuan->delete();

        return redirect()->route('k3.restock')->with('success', 'Pengajuan berhasil dihapus.');
    }
}
