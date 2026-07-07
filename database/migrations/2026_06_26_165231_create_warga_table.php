<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('warga')) {
            return;
        }

        Schema::create('warga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Identitas
            $table->string('nik', 16)->unique();
            $table->string('nomor_kk', 16);
            $table->string('nama');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('golongan_darah', 5)->nullable();
            $table->string('agama')->nullable();
            $table->string('status_pernikahan')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('telepon', 20);
            $table->string('email')->nullable();

            // Alamat
            $table->text('alamat');
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->string('dusun')->nullable();
            $table->string('desa')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_pos', 10)->nullable();

            // Administrasi
            $table->string('bpjs_number')->nullable();
            $table->string('kis_number')->nullable();
            $table->string('jkn_number')->nullable();
            $table->enum('status_kependudukan', ['tetap', 'pendatang'])->default('tetap');
            $table->enum('status_keaktifan', ['aktif', 'tidak_aktif'])->default('aktif');

            // Dokumen
            $table->string('ktp_path')->nullable();
            $table->string('kk_path')->nullable();

            // Verifikasi
            $table->enum('verification_status', ['belum_lengkap', 'pending', 'verified', 'rejected'])->default('belum_lengkap');
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->text('rejected_reason')->nullable();

            // SoftDeletes & Timestamps
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warga');
    }
};
