<?php

use App\Models\Balita;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Support\Facades\Hash;

test('pegawai can delete warga data', function () {
    $user = User::create([
        'name' => 'Pegawai Test',
        'email' => 'pegawai-delete-' . uniqid() . '@example.com',
        'password' => Hash::make('password123'),
        'role' => 'pegawai',
        'email_verified_at' => now(),
    ]);

    $warga = Warga::create([
        'user_id' => $user->id,
        'nik' => '1234567890123456',
        'nomor_kk' => '1234567890123456',
        'nama' => 'Warga Test',
        'tempat_lahir' => 'Bandung',
        'tanggal_lahir' => '1990-01-01',
        'jenis_kelamin' => 'L',
        'status_kependudukan' => 'tetap',
        'status_keaktifan' => 'aktif',
        'alamat' => 'Jl. Test No. 1',
        'telepon' => '081234567890',
    ]);

    $response = $this->actingAs($user)->delete(route('pegawai.warga.destroy', $warga));

    $response->assertRedirect(route('pegawai.warga.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseMissing('warga', ['id' => $warga->id]);
});

test('pegawai can delete warga data with related balita records', function () {
    $user = User::create([
        'name' => 'Pegawai Test 2',
        'email' => 'pegawai-delete-2-' . uniqid() . '@example.com',
        'password' => Hash::make('password123'),
        'role' => 'pegawai',
        'email_verified_at' => now(),
    ]);

    $warga = Warga::create([
        'user_id' => $user->id,
        'nik' => '2234567890123456',
        'nomor_kk' => '2234567890123456',
        'nama' => 'Warga Test 2',
        'tempat_lahir' => 'Bandung',
        'tanggal_lahir' => '1990-01-01',
        'jenis_kelamin' => 'P',
        'status_kependudukan' => 'tetap',
        'status_keaktifan' => 'aktif',
        'alamat' => 'Jl. Test No. 2',
        'telepon' => '081234567891',
    ]);

    Balita::create([
        'warga_id' => $warga->id,
        'nama' => 'Balita Test',
        'tanggal_lahir' => '2024-01-01',
        'jenis_kelamin' => 'L',
    ]);

    $response = $this->actingAs($user)->delete(route('pegawai.warga.destroy', $warga));

    $response->assertRedirect(route('pegawai.warga.index'));
    $response->assertSessionHas('success');
    $this->assertDatabaseMissing('warga', ['id' => $warga->id]);
    $this->assertDatabaseMissing('balita', ['warga_id' => $warga->id]);
});
