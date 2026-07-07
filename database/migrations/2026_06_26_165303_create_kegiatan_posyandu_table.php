<?php
// database/migrations/2026_06_26_165303_create_kegiatan_posyandu_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kegiatan_posyandu', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai')->nullable();
            $table->string('lokasi');
            $table->enum('status', ['terjadwal', 'berlangsung', 'selesai', 'dibatalkan'])->default('terjadwal');
            $table->string('penanggung_jawab');
            $table->string('google_maps_embed')->nullable();
            $table->integer('kuota')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Tabel konfirmasi kehadiran
        Schema::create('kehadiran_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')->constrained('kegiatan_posyandu')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('konfirmasi_at')->nullable();
            $table->timestamp('hadir_at')->nullable();
            $table->enum('status', ['terdaftar', 'hadir', 'tidak_hadir'])->default('terdaftar');
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            $table->unique(['kegiatan_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('kehadiran_kegiatan');
        Schema::dropIfExists('kegiatan_posyandu');
    }
};