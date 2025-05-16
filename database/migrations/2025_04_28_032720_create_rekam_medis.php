<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateRekamMedis extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();                                              // PK
            $table->foreignId('kunjungan_id')                          // FK ke kunjungan
                ->constrained('kunjungan')
                ->onDelete('cascade');
            $table->foreignId('dokter_id')                             // FK ke users (role=dokter)
                ->constrained('users')
                ->onDelete('cascade');
            $table->text('ttv');                                       // Tanda-Tanda Vital
            $table->text('hasil_mcu');                                  // Hasil Medical Check-Up
            $table->text('diagnosis');                                  // Diagnosis dokter
            $table->timestamps();                                       // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};
