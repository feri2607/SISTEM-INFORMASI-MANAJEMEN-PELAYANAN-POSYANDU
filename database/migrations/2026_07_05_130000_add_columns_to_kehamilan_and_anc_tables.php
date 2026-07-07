<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom baru ke tabel kehamilan
        Schema::table('kehamilan', function (Blueprint $table) {
            $table->string('nama')->nullable()->after('warga_id');
            $table->string('nik', 16)->nullable()->after('nama');
            $table->date('tanggal_lahir')->nullable()->after('nik');
            $table->string('no_hp')->nullable()->after('tanggal_lahir');
            $table->text('alamat')->nullable()->after('no_hp');
            $table->integer('kehamilan_ke')->default(1)->after('alamat');
            $table->text('riwayat_alergi')->nullable()->after('riwayat_penyakit');
            $table->string('foto')->nullable()->after('riwayat_alergi');
            $table->boolean('is_verified')->default(false)->after('status');
            $table->unsignedBigInteger('verified_by')->nullable()->after('is_verified');
            $table->timestamp('verified_at')->nullable()->after('verified_by');
        });

        // Tambah kolom baru ke tabel anc
        Schema::table('anc', function (Blueprint $table) {
            $table->decimal('lila', 5, 2)->nullable()->after('berat_badan');
            $table->string('posisi_janin')->nullable()->after('detak_jantung');
            $table->text('diagnosis')->nullable()->after('keluhan');
            $table->boolean('pemberian_ttd')->default(false)->after('diagnosis');
            $table->boolean('rujukan')->default(false)->after('pemberian_ttd');
        });
    }

    public function down(): void
    {
        Schema::table('anc', function (Blueprint $table) {
            $table->dropColumn(['lila', 'posisi_janin', 'diagnosis', 'pemberian_ttd', 'rujukan']);
        });

        Schema::table('kehamilan', function (Blueprint $table) {
            $table->dropColumn(['nama', 'nik', 'tanggal_lahir', 'no_hp', 'alamat', 'kehamilan_ke',
                                'riwayat_alergi', 'foto', 'is_verified', 'verified_by', 'verified_at']);
        });
    }
};
