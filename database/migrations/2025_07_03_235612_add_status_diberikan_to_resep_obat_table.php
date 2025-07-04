<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusDiberikanToResepObatTable extends Migration
{
    public function up()
    {
        Schema::table('resep_obat', function (Blueprint $table) {
            $table->boolean('status_diberikan')->default(false)->after('aturan_pakai');
        });
    }

    public function down()
    {
        Schema::table('resep_obat', function (Blueprint $table) {
            $table->dropColumn('status_diberikan');
        });
    }
}
