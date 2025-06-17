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
        Schema::table('kunjungan', function (Blueprint $table) {
            $table->string('status')->default('belum ditangani');
            $table->foreignId('ditangani_oleh')->nullable()->constrained('users')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kunjungan', function (Blueprint $table) {
            //
        });
    }
};
