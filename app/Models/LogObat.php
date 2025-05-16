<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogObat extends Model
{
    use HasFactory;

    protected $table = 'log_obat';

    protected $fillable = [
        'obat_id',
        'jenis_mutasi',
        'jumlah',
        'sisa_stok',
        'tgl_transaksi',
        'tgl_exp',
        'keterangan',
        'ref_type',
        'ref_id',
    ];

    /**
     * Relasi ke model Obat
     */
    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }

    /**
     * Polymorphic relasi manual (opsional tergantung ref_type)
     */
    public function referensi()
    {
        return match ($this->ref_type) {
            'resep' => $this->belongsTo(ResepObat::class, 'ref_id'),
            'restock' => $this->belongsTo(RestockObat::class, 'ref_id'),
            default => null,
        };
    }
}
