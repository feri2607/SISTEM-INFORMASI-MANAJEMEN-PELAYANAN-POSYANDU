<?php
// database/migrations/2026_01_01_000005_create_hasil_pelayanan_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('hasil_pelayanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kegiatan_id')->constrained('kegiatan_posyandu')->onDelete('cascade');
            $table->foreignId('balita_id')->constrained('balita')->onDelete('cascade');
            $table->decimal('berat_badan', 5, 2);
            $table->decimal('tinggi_badan', 5, 2);
            $table->decimal('lingkar_kepala', 5, 2);
            $table->decimal('lingkar_lengan', 5, 2)->nullable();
            $table->decimal('suhu_tubuh', 4, 1)->nullable();
            $table->enum('status_gizi', ['normal', 'kurang', 'buruk', 'lebih']);
            $table->json('imunisasi')->nullable();
            $table->json('vitamin')->nullable();
            $table->text('catatan')->nullable();
            $table->text('rekomendasi')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hasil_pelayanan');
    }
};