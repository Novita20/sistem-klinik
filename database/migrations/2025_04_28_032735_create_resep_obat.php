<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResepObat extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resep_obat', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('rekam_medis_id') // FK ke rekam_medis
                ->constrained('rekam_medis')
                ->onDelete('cascade');
            $table->foreignId('obat_id') // FK ke obat
                ->constrained('obat')
                ->onDelete('cascade');
            $table->integer('jumlah'); // Jumlah obat yang diresepkan
            $table->text('keterangan')->nullable(); // Optional, misalnya aturan pakai
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resep_obat');
    }
}
