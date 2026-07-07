<?php
// database/migrations/2026_01_01_000025_create_wus_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('konseling_reproduksi');
        Schema::dropIfExists('pelayanan_reproduksi');
        Schema::dropIfExists('pus');
        Schema::dropIfExists('wus');

        Schema::create('wus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('warga_id');
            $table->string('nama');
            $table->string('nik', 16)->unique();
            $table->date('tanggal_lahir');
            $table->string('status_pernikahan')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('golongan_darah')->nullable();
            $table->text('riwayat_penyakit')->nullable();
            $table->string('status_anemia')->nullable();
            $table->string('foto')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });

        Schema::create('pus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('warga_id');
            $table->string('nama_pasangan');
            $table->integer('jumlah_anak')->default(0);
            $table->string('status_kb')->nullable();
            $table->string('jenis_kontrasepsi')->nullable();
            $table->date('tanggal_mulai_kb')->nullable();
            $table->date('jadwal_kontrol')->nullable();
            $table->timestamps();
        });

        Schema::create('pelayanan_reproduksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wus_id');
            $table->unsignedBigInteger('user_id');
            $table->date('tanggal');
            $table->string('jenis_pelayanan');
            $table->string('jenis_kontrasepsi')->nullable();
            $table->text('hasil_pemeriksaan')->nullable();
            $table->text('catatan')->nullable();
            $table->date('jadwal_kontrol_berikutnya')->nullable();
            $table->timestamps();
        });

        Schema::create('konseling_reproduksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wus_id');
            $table->unsignedBigInteger('user_id');
            $table->date('tanggal');
            $table->string('topik');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down()
    {
        Schema::dropIfExists('konseling_reproduksi');
        Schema::dropIfExists('pelayanan_reproduksi');
        Schema::dropIfExists('pus');
        Schema::dropIfExists('wus');
    }
};