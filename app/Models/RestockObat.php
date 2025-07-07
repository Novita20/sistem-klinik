<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestockObat extends Model
{
    use HasFactory;

    protected $table = 'restock_obat';

    protected $fillable = [
        'obat_id',
        'jumlah',
        'status',
        'tanggal_pengajuan',
    ];

    /**
     * Relasi ke model Obat
     */
    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }

    /**
     * Relasi ke user yang melakukan permintaan restock
     */
    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    /**
     * Relasi ke user yang menyetujui permintaan restock
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
