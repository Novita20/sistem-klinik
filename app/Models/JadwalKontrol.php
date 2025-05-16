<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKontrol extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kontrol';

    protected $fillable = [
        'kunjungan_id',
        'tanggal_kontrol',
        'reminder_sent_at',
        'status',
    ];

    // Relasi ke Kunjungan
    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class);
    }
}
