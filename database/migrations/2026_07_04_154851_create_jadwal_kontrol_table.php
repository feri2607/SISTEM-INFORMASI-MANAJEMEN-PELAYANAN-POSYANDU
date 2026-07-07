<?php
// database/migrations/2026_01_01_000028_create_jadwal_kontrol_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jadwal_kontrol', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wus_id')->constrained('wus')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam');
            $table->string('lokasi');
            $table->enum('status', ['terjadwal', 'hadir', 'tidak_hadir'])->default('terjadwal');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwal_kontrol');
    }
};