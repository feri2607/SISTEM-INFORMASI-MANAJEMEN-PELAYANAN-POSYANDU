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
        Schema::table('balita', function (Blueprint $table) {
            $table->string('nik', 16)->nullable();
            $table->string('nomor_kk', 16)->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->text('alamat')->nullable();
            $table->string('golongan_darah', 5)->nullable();
            $table->string('no_hp_orang_tua')->nullable();
            $table->string('foto_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('balita', function (Blueprint $table) {
            $table->dropColumn([
                'nik',
                'nomor_kk',
                'nama_ayah',
                'nama_ibu',
                'alamat',
                'golongan_darah',
                'no_hp_orang_tua',
                'foto_path'
            ]);
        });
    }
};
