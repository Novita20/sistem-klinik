<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'obat';

    // Field yang dapat diisi mass-assignment
    protected $fillable = [
        'nama_obat',
        'jenis_obat',     // tambahkan jika disimpan
        'satuan',
        'stok',
        'expired_at'      // tambahkan jika disimpan
    ];

    /**
     * Relasi ke tabel resep_obat (jika satu obat bisa digunakan di banyak resep)
     */
    public function resepObat()
    {
        return $this->hasMany(ResepObat::class, 'obat_id');
    }

    /**
     * Relasi ke log_obat (untuk mutasi masuk/keluar)
     */
    public function logObat()
    {
        return $this->hasMany(LogObat::class, 'obat_id');
    }

    /**
     * Scope pencarian obat yang stok-nya rendah (opsional)
     */
    public function scopeStokRendah($query, $batas = 10)
    {
        return $query->where('stok', '<=', $batas);
    }
}
