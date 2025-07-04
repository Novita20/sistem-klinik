<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResepObat extends Model
{
    use HasFactory;

    protected $table = 'resep_obat';

    protected $fillable = [
        'rekam_medis_id',
        'obat_id',
        'jumlah',
        'dosis',
        'aturan_pakai',
        'pasien_id',
    ];


    /**
     * Relasi ke rekam medis
     */
    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class);
    }

    /**
     * Relasi ke obat
     */
    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }


    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id');
    }

    public function logObat()
    {
        return $this->hasOne(\App\Models\LogObat::class, 'ref_id', 'id')
            ->where('ref_type', 'resep');
    }
}
