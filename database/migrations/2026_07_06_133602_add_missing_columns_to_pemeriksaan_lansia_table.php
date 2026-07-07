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
        Schema::table('pemeriksaan_lansia', function (Blueprint $table) {
            $table->string('keluhan')->nullable()->after('tanggal');
            $table->decimal('asam_urat', 5, 2)->nullable()->after('lingkar_perut');
            $table->text('tindakan')->nullable()->after('catatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemeriksaan_lansia', function (Blueprint $table) {
            $table->dropColumn(['keluhan', 'asam_urat', 'tindakan']);
        });
    }
};
