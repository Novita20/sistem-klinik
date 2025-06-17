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
        Schema::table('obat', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->string('jenis_obat')->nullable()->after('stok');
            $table->date('expired_at')->nullable()->after('jenis_obat');
        });
    }

    public function down()
    {
        Schema::table('obat', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->dropColumn(['jenis_obat', 'expired_at']);
        });
    }
};
