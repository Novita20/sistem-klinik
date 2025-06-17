<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('resep_obat', function (Blueprint $table) {
            $table->unsignedBigInteger('pasien_id')->after('id');

            // Kalau ingin buat relasi foreign key:
            $table->foreign('pasien_id')->references('id')->on('pasien')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resep_obat', function (Blueprint $table) {
            //
        });
    }
};
