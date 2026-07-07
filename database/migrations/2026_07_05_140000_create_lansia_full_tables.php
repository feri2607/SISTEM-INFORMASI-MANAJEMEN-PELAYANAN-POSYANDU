<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Recreate lansia table with all columns if needed
        if (!Schema::hasTable('lansia')) {
            Schema::create('lansia', function (Blueprint $table) {
                $table->id();
                $table->foreignId('warga_id')->constrained('warga')->onDelete('cascade');
                $table->string('nama');
                $table->string('nik')->unique()->nullable();
                $table->date('tanggal_lahir')->nullable();
                $table->enum('jenis_kelamin', ['L', 'P']);
                $table->text('alamat')->nullable();
                $table->string('golongan_darah')->nullable();
                $table->text('riwayat_penyakit')->nullable();
                $table->string('no_hp')->nullable();
                $table->string('foto')->nullable();
                $table->boolean('is_verified')->default(false);
                $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamp('verified_at')->nullable();
                $table->timestamps();
            });
        } else {
            // Add missing columns to existing table
            Schema::table('lansia', function (Blueprint $table) {
                if (!Schema::hasColumn('lansia', 'nik')) {
                    $table->string('nik')->unique()->nullable()->after('nama');
                }
                if (!Schema::hasColumn('lansia', 'tanggal_lahir')) {
                    $table->date('tanggal_lahir')->nullable()->after('nik');
                }
                if (!Schema::hasColumn('lansia', 'alamat')) {
                    $table->text('alamat')->nullable()->after('jenis_kelamin');
                }
                if (!Schema::hasColumn('lansia', 'no_hp')) {
                    $table->string('no_hp')->nullable()->after('golongan_darah');
                }
                if (!Schema::hasColumn('lansia', 'foto')) {
                    $table->string('foto')->nullable()->after('no_hp');
                }
                if (!Schema::hasColumn('lansia', 'verified_by')) {
                    $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete()->after('is_verified');
                }
                if (!Schema::hasColumn('lansia', 'verified_at')) {
                    $table->timestamp('verified_at')->nullable()->after('verified_by');
                }
            });
        }

        // Pemeriksaan Lansia
        if (!Schema::hasTable('pemeriksaan_lansia')) {
            Schema::create('pemeriksaan_lansia', function (Blueprint $table) {
                $table->id();
                $table->foreignId('lansia_id')->constrained('lansia')->onDelete('cascade');
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->date('tanggal');
                $table->string('tekanan_darah')->nullable(); // "120/80"
                $table->decimal('gula_darah', 6, 2)->nullable();
                $table->decimal('kolesterol', 6, 2)->nullable();
                $table->decimal('berat_badan', 5, 2)->nullable();
                $table->decimal('tinggi_badan', 5, 2)->nullable();
                $table->decimal('imt', 5, 2)->nullable();
                $table->decimal('lingkar_perut', 5, 2)->nullable();
                $table->text('catatan')->nullable();
                $table->timestamps();
            });
        }

        // Jadwal Senam Lansia
        if (!Schema::hasTable('jadwal_senam_lansia')) {
            Schema::create('jadwal_senam_lansia', function (Blueprint $table) {
                $table->id();
                $table->date('tanggal');
                $table->time('jam');
                $table->string('lokasi');
                $table->string('instruktur')->nullable();
                $table->integer('kuota')->default(0);
                $table->enum('status', ['aktif', 'selesai', 'dibatalkan'])->default('aktif');
                $table->timestamps();
            });
        }

        // Kehadiran Senam Lansia
        if (!Schema::hasTable('kehadiran_senam_lansia')) {
            Schema::create('kehadiran_senam_lansia', function (Blueprint $table) {
                $table->id();
                $table->foreignId('jadwal_senam_lansia_id')->constrained('jadwal_senam_lansia')->onDelete('cascade');
                $table->foreignId('lansia_id')->constrained('lansia')->onDelete('cascade');
                $table->boolean('hadir')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('kehadiran_senam_lansia');
        Schema::dropIfExists('jadwal_senam_lansia');
        Schema::dropIfExists('pemeriksaan_lansia');
        Schema::dropIfExists('lansia');
    }
};
