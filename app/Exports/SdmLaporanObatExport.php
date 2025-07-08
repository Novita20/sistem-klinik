<?php

namespace App\Exports;

use App\Models\ResepObat;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SdmLaporanObatExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = ResepObat::with('obat');

        if ($this->request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $this->request->start_date);
        }

        if ($this->request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $this->request->end_date);
        }

        if ($this->request->filled('search')) {
            $query->whereHas('obat', function ($q) {
                $q->where('nama_obat', 'like', '%' . $this->request->search . '%');
            });
        }

        $resepList = $query->get();

        $data = $resepList->groupBy('obat_id')->map(function ($items) {
            $first = $items->first();
            return [
                'nama_obat' => $first->obat->nama_obat ?? '-',
                'frekuensi' => $items->count(),
                'terakhir_digunakan' => $items->max('created_at'),
            ];
        })->sortByDesc('frekuensi')->values()->all();

        return view('sdm.laporan.excel', compact('data'));
    }
}
