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
        Schema::create('perkembangan_balitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('balita_id')->constrained('balita')->cascadeOnDelete();
            $table->date('tanggal');
            $table->text('motorik_kasar')->nullable();
            $table->text('motorik_halus')->nullable();
            $table->text('bahasa')->nullable();
            $table->text('sosial')->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('pegawai_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perkembangan_balitas');
    }
};
