<?php

namespace App\Exports;

use App\Models\Kunjungan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ParamedisRiwayatKunjunganExport implements FromCollection, WithHeadings
{
    protected $search;

    public function __construct($search = null)
    {
        $this->search = $search;
    }

    public function collection()
    {
        return Kunjungan::with('pasien.user')
            ->when($this->search, function ($query) {
                $query->whereHas('pasien.user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->orderByDesc('tgl_kunjungan')
            ->get()
            ->map(function ($item) {
                return [
                    'Nama Pasien' => $item->pasien->user->name ?? '-',
                    'Tanggal Kunjungan' => \Carbon\Carbon::parse($item->tgl_kunjungan)->format('d-m-Y H:i'),
                    'Keluhan' => $item->keluhan ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return ['Nama Pasien', 'Tanggal Kunjungan', 'Keluhan'];
    }
}
