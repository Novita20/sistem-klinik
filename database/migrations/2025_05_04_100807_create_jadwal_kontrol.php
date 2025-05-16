<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalKontrol extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_kontrol', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kunjungan_id')
                ->constrained('kunjungan')
                ->onDelete('cascade');
            $table->date('tanggal_kontrol');
            $table->dateTime('reminder_sent_at')->nullable();
            $table->enum('status', ['terjadwal', 'selesai', 'batal'])
                ->default('terjadwal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_kontrol');
    }
}
