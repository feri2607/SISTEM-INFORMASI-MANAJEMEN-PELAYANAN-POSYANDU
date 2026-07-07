<?php
// database/migrations/2026_01_01_000022_add_status_verifikasi_to_warga_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('warga', function (Blueprint $table) {
            if (!Schema::hasColumn('warga', 'status_verifikasi')) {
                $table->enum('status_verifikasi', ['pending', 'verified', 'rejected'])->default('pending')->after('user_id');
            }
            if (!Schema::hasColumn('warga', 'alasan_penolakan')) {
                $table->text('alasan_penolakan')->nullable()->after('status_verifikasi');
            }
        });
    }

    public function down()
    {
        Schema::table('warga', function (Blueprint $table) {
            $table->dropColumn(['status_verifikasi', 'alasan_penolakan']);
        });
    }
};