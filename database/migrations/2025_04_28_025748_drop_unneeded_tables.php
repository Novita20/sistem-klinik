<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Menghapus tabel yang tidak diperlukan
        Schema::dropIfExists('cache');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('job_batches');
    }

    // Bagian down() bisa dikosongkan atau dihapus
    public function down(): void
    {
        // Tidak perlu buat ulang tabel
    }
};
