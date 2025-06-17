<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nid',
        'username',
        'name',
        'email',
        'password',
        'role',
        'status',
        'profile_picture',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Jika kamu tetap menyimpan kolom email_verified_at, kamu bisa aktifkan bagian ini:
    // protected function casts(): array
    // {
    //     return [
    //         'email_verified_at' => 'datetime',
    //         'password' => 'hashed',
    //     ];
    // }

    // Kalau kamu sudah menghapus kolom email_verified_at dari database, gunakan ini:
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function pasien()
    {
        return $this->hasOne(Pasien::class, 'user_id');
    }

    public function kunjunganSebagaiPasien()
    {
        return $this->hasMany(Kunjungan::class, 'pasien_id');
    }

    public function kunjunganSebagaiParamedis()
    {
        return $this->hasMany(Kunjungan::class, 'paramedis_id');
    }

    public function rekamMedisSebagaiDokter()
    {
        return $this->hasMany(RekamMedis::class, 'dokter_id');
    }

    public function restockDiminta()
    {
        return $this->hasMany(RestockObat::class, 'requested_by');
    }

    public function restockDisetujui()
    {
        return $this->hasMany(RestockObat::class, 'approved_by');
    }
}
