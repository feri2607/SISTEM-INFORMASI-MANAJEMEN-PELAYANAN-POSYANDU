<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Warga;
use App\Models\Balita;
use App\Models\KegiatanPosyandu;
use App\Models\HasilPelayanan;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Run RolePermissionSeeder first
        $this->call(RolePermissionSeeder::class);

        // 2. Create admin user
        $admin = User::create([
            'name' => 'Admin Posyandu',
            'email' => 'lferiadin@gmail.com',
            'password' => Hash::make('@Qwerty12344321'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin');

    //     // 3. Create some users
    //     $users = User::factory(5)->create(['role' => 'user', 'email_verified_at' => now()]);
    //     foreach ($users as $user) {
    //         $user->assignRole('user');
    //     }

    //     // 4. Create warga for each user
    //     foreach ($users as $user) {
    //         Warga::factory(3)->create(['user_id' => $user->id]);
    //     }

    //     // 5. Create warga for admin
    //     Warga::factory(2)->create(['user_id' => $admin->id]);

    //     // 6. Create balita for each warga
    //     Warga::all()->each(function ($warga) {
    //         Balita::factory(2)->create(['warga_id' => $warga->id]);
    //     });

    //     // 7. Create kegiatan
    //     KegiatanPosyandu::factory(10)->create(['user_id' => User::inRandomOrder()->first()->id]);

    //     // 8. Create hasil pelayanan
    //     KegiatanPosyandu::all()->each(function ($kegiatan) {
    //         $balita = Balita::inRandomOrder()->first();
    //         if ($balita) {
    //             HasilPelayanan::factory(3)->create([
    //                 'kegiatan_id' => $kegiatan->id,
    //                 'balita_id' => $balita->id,
    //                 'user_id' => $kegiatan->user_id,
    //             ]);
    //         }
    //     });
     }
}