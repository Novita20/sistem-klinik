<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis';

    protected $fillable = [
        'kunjungan_id',
        'dokter_id',
        'ttv',
        'hasil_mcu',
        'diagnosis',
    ];

    /**
     * Relasi ke kunjungan
     */
    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class);
    }

    /**
     * Relasi ke user sebagai dokter
     */
    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }
}
