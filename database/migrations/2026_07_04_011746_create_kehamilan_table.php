<?php
// database/migrations/2026_01_01_000024_create_kehamilan_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kehamilan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_id')->constrained('warga')->onDelete('cascade');
            $table->date('hpht')->nullable();
            $table->date('hpl')->nullable();
            $table->integer('usia_kehamilan')->nullable();
            $table->string('golongan_darah')->nullable();
            $table->text('riwayat_penyakit')->nullable();
            $table->boolean('risiko_tinggi')->default(false);
            $table->string('status')->default('aktif');
            $table->timestamps();
        });

        Schema::create('anc', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kehamilan_id')->constrained('kehamilan')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->integer('minggu_ke');
            $table->string('tekanan_darah')->nullable();
            $table->decimal('berat_badan', 5, 2)->nullable();
            $table->decimal('tinggi_fundus', 5, 2)->nullable();
            $table->integer('detak_jantung')->nullable();
            $table->text('keluhan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('konsumsi_ttd', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kehamilan_id')->constrained('kehamilan')->onDelete('cascade');
            $table->integer('jumlah_target')->default(90);
            $table->integer('jumlah_diminum')->default(0);
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();
        });

        Schema::create('menyusui', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_id')->constrained('warga')->onDelete('cascade');
            $table->foreignId('balita_id')->constrained('balita')->onDelete('cascade');
            $table->boolean('asi_eksklusif')->default(false);
            $table->date('mulai_menyusui')->nullable();
            $table->date('target_asi')->nullable();
            $table->timestamps();
        });

        Schema::create('konseling_menyusui', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menyusui_id')->constrained('menyusui')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('topik');
            $table->text('kesimpulan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('konseling_menyusui');
        Schema::dropIfExists('menyusui');
        Schema::dropIfExists('konsumsi_ttd');
        Schema::dropIfExists('anc');
        Schema::dropIfExists('kehamilan');
    }
};