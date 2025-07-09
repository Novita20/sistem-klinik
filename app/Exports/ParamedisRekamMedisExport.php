<?php

namespace App\Exports;

use App\Models\RekamMedis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ParamedisRekamMedisExport implements FromCollection, WithHeadings
{
    protected $search;

    public function __construct($search = null)
    {
        $this->search = $search;
    }

    public function collection()
    {
        return RekamMedis::with(['kunjungan.pasien.user', 'resepObat.obat'])
            ->when($this->search, function ($query) {
                $query->whereHas('kunjungan.pasien.user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->get()
            ->map(function ($rm) {
                $ttv = json_decode($rm->ttv ?? '{}');
                return [
                    'Nama Pasien' => $rm->kunjungan->pasien->user->name ?? '-',
                    'Keluhan' => $rm->kunjungan->keluhan ?? '-',
                    'Anamnesa' => $rm->anamnesa ?? '-',
                    'Diagnosa' => $rm->diagnosis ?? '-',
                    'Tindakan' => $rm->tindakan ?? '-',
                    'TD' => $ttv->tekanan_darah ?? '-',
                    'Nadi' => $ttv->nadi ?? '-',
                    'Suhu' => $ttv->suhu ?? '-',
                    'RR' => $ttv->rr ?? '-',
                    'SpO₂' => $ttv->spo2 ?? '-',
                    'GDA' => $ttv->gda ?? '-',
                    'Asam Urat' => $ttv->asam_urat ?? '-',
                    'Kolesterol' => $ttv->kolesterol ?? '-',
                    'Resep Obat' => $rm->resepObat->map(function ($r) {
                        return ($r->obat->nama_obat ?? '-') . ' - ' . ($r->dosis ?? '-') . ' - ' . ($r->aturan_pakai ?? '-');
                    })->implode(', '),
                    'Tanggal Kunjungan' => optional($rm->kunjungan->tgl_kunjungan)->format('d-m-Y H:i'),
                    'Tanggal Ditangani' => optional($rm->created_at)->format('d-m-Y H:i'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama Pasien',
            'Keluhan',
            'Anamnesa',
            'Diagnosa',
            'Tindakan',
            'TD',
            'Nadi',
            'Suhu',
            'RR',
            'SpO₂',
            'GDA',
            'Asam Urat',
            'Kolesterol',
            'Resep Obat',
            'Tanggal Kunjungan',
            'Tanggal Ditangani'
        ];
    }
}
