<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogObat extends Migration
{
    public function up(): void
    {
        Schema::create('log_obat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obat_id')->constrained('obat')->onDelete('cascade');
            $table->enum('jenis_mutasi', ['masuk', 'keluar']);
            $table->integer('jumlah');
            $table->integer('sisa_stok'); // stok setelah transaksi
            $table->date('tgl_transaksi');
            $table->date('tgl_exp')->nullable(); // untuk batch masuk
            $table->text('keterangan')->nullable();
            $table->enum('ref_type', ['resep', 'restock', 'manual'])->nullable();
            $table->unsignedBigInteger('ref_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_obat');
    }
}
