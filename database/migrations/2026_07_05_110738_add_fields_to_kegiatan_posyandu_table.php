<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kegiatan_posyandu', function (Blueprint $table) {
            $table->string('posyandu')->nullable()->after('nama_kegiatan');
            $table->json('jenis_pelayanan')->nullable()->after('deskripsi');
            $table->string('target_peserta')->nullable()->after('jenis_pelayanan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kegiatan_posyandu', function (Blueprint $table) {
            $table->dropColumn(['posyandu', 'jenis_pelayanan', 'target_peserta']);
        });
    }
};
