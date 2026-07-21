<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('warga', function (Blueprint $table) {
            $table->enum('status_kehamilan', ['ya', 'tidak'])->default('tidak')->after('status_keaktifan');
            $table->enum('status_menyusui', ['ya', 'tidak'])->default('tidak')->after('status_kehamilan');
            $table->text('catatan_kesehatan')->nullable()->after('status_menyusui');
        });
    }

    public function down(): void
    {
        Schema::table('warga', function (Blueprint $table) {
            $table->dropColumn(['status_kehamilan', 'status_menyusui', 'catatan_kesehatan']);
        });
    }
};
