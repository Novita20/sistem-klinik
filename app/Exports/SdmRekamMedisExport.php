<?php

namespace App\Exports;

use App\Models\RekamMedis;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SdmRekamMedisExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = RekamMedis::with(['kunjungan.pasien.user', 'resepObat.obat']);

        // Filter berdasarkan pencarian nama pasien
        if ($this->request->filled('search')) {
            $query->whereHas('kunjungan.pasien.user', function ($q) {
                $q->where('name', 'like', '%' . $this->request->search . '%');
            });
        }

        $rekammedis = $query->get();

        return view('sdm.rekamMedis.excel', compact('rekammedis'));
    }
}
