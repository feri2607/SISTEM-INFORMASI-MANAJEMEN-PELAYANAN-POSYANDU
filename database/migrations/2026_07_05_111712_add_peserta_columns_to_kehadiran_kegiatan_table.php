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
        Schema::table('kehadiran_kegiatan', function (Blueprint $table) {
            $table->nullableMorphs('peserta'); // creates peserta_id and peserta_type
            $table->string('kategori')->nullable()->after('peserta_type');
            $table->time('jam_datang')->nullable()->after('kategori');
            $table->string('status_kehadiran')->default('Belum Hadir')->after('jam_datang'); // replaces custom enum if necessary
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kehadiran_kegiatan', function (Blueprint $table) {
            $table->dropMorphs('peserta');
            $table->dropColumn(['kategori', 'jam_datang', 'status_kehadiran']);
        });
    }
};
