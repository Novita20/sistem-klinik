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
        Schema::table('log_obat', function (Blueprint $table) {
            $table->date('expired_at')->nullable()->after('tgl_transaksi');
        });
    }

    public function down()
    {
        Schema::table('log_obat', function (Blueprint $table) {
            $table->dropColumn('expired_at');
        });
    }
};
