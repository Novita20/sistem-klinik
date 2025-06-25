<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    use HasFactory;

    protected $table = 'kunjungan';

    protected $fillable = [
        'pasien_id',
        'paramedis_id',
        'tgl_kunjungan',
        'status',
        'keluhan',
    ];

    // Relasi ke user sebagai pasien
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id'); // ✅ Benar
    }

    // Relasi ke user sebagai paramedis
    public function paramedis()
    {
        return $this->belongsTo(User::class, 'paramedis_id');
    }

    // Relasi ke rekam medis
    public function rekamMedis()
    {
        return $this->hasOne(RekamMedis::class, 'kunjungan_id');
    }
}
