<?php
// database/migrations/2026_01_01_000009_create_about_posyandu_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('about_posyandu', function (Blueprint $table) {
            $table->id();
            $table->string('nama_posyandu');
            $table->text('deskripsi');
            $table->text('sejarah');
            $table->string('visi');
            $table->json('misi');
            $table->json('tujuan');
            $table->string('motto')->nullable();
            $table->string('tahun_berdiri');
            $table->string('wilayah_pelayanan');
            $table->string('alamat');
            $table->string('telepon');
            $table->string('email');
            $table->string('jam_operasional');
            $table->text('google_maps_embed')->nullable();
            $table->string('foto_hero')->nullable();
            $table->string('foto_profil')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('struktur_organisasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan');
            $table->string('foto')->nullable();
            $table->text('deskripsi')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('galeris', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('foto');
            $table->text('deskripsi')->nullable();
            $table->string('kategori')->default('kegiatan');
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('nilai_posyandu', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('ikon')->nullable();
            $table->text('deskripsi');
            $table->integer('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nilai_posyandu');
        Schema::dropIfExists('galeris');
        Schema::dropIfExists('struktur_organisasis');
        Schema::dropIfExists('about_posyandu');
    }
};