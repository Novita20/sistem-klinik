<?php

namespace App\Exports;

use App\Models\RestockObat;
use App\Models\ResepObat;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanObatK3Export implements FromView
{
    protected $startDate;
    protected $endDate;
    protected $search;

    public function __construct($startDate = null, $endDate = null, $search = null)
    {
        $this->startDate = $startDate ?? '2000-01-01';
        $this->endDate = $endDate ?? now()->toDateString();
        $this->search = $search;
    }

    public function view(): View
    {
        // Ambil data dari ResepObat (bukan RestockObat)
        $reseps = ResepObat::with('obat')
            ->where('status_diberikan', 1)
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->when($this->search, function ($query) {
                $query->whereHas('obat', function ($q) {
                    $q->where('nama_obat', 'like', '%' . $this->search . '%');
                });
            })
            ->get();

        // Grupkan dan siapkan data
        $data = $reseps->groupBy('obat_id')->map(function ($group) {
            return [
                'nama_obat' => $group->first()->obat->nama_obat ?? '-',
                'frekuensi' => $group->count(),
                'terakhir_digunakan' => optional($group->sortByDesc('created_at')->first()->created_at)->format('d-m-Y'),
            ];
        })->values();

        // Kirim ke view Excel
        return view('k3.excel', ['data' => $data]);
    }
}
