<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $table = 'obat';

    protected $fillable = [
        'nama_obat',
        'satuan',
        'stok',
    ];

    /**
     * Relasi ke resep obat (jika digunakan)
     */
    public function resepObat()
    {
        return $this->hasMany(ResepObat::class);
    }

    /**
     * Relasi ke log obat (jika ada)
     */
    public function logObat()
    {
        return $this->hasMany(LogObat::class);
    }
}
