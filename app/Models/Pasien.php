<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    protected $fillable = [
        'user_id',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'status',
    ];

    /**
     * Relasi ke model User
     * Pasien dimiliki oleh satu user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
