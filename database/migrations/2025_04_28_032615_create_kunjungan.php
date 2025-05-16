<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKunjungan extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kunjungan', function (Blueprint $table) {
            $table->id(); // Primary Key 'id'
            $table->foreignId('pasien_id') // FK ke users.id (role pasien)
                ->constrained('users') // Menghubungkan ke 'users.id'
                ->onDelete('cascade'); // Jika pasien dihapus, kunjungan ikut terhapus
            $table->foreignId('paramedis_id') // FK ke users.id (role paramedis)
                ->constrained('users') // Menghubungkan ke 'users.id'
                ->onDelete('cascade'); // Jika paramedis dihapus, kunjungan ikut terhapus
            $table->date('tgl_kunjungan'); // Tanggal kunjungan
            $table->text('keluhan'); // Keluhan pasien
            $table->timestamps(); // created_at & updated_at otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungan'); // Menghapus tabel 'kunjungan'
    }
};
