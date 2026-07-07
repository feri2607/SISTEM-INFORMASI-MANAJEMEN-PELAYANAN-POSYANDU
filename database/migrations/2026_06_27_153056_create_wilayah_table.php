<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Buat tabel wilayah tanpa self-referencing FK yang bermasalah di SQLite
        // parent_id tetap ada sebagai integer biasa
        if (!Schema::hasTable('wilayah')) {
            Schema::create('wilayah', function (Blueprint $table) {
                $table->id();
                $table->string('kode')->unique();
                $table->string('nama');
                $table->enum('tingkat', ['provinsi', 'kabupaten', 'kecamatan', 'kelurahan']);
                $table->unsignedBigInteger('parent_id')->nullable();
                $table->timestamps();
            });
        }

        // Tambah kolom wilayah di tabel warga (hanya jika belum ada)
        // Kolom ini sudah ada di create_warga migration terbaru, jadi ini skip
    }

    public function down()
    {
        Schema::dropIfExists('wilayah');
    }
};