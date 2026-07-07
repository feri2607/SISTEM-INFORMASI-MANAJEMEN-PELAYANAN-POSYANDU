<?php

namespace Database\Factories;

use App\Models\KegiatanPosyandu;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KegiatanPosyandu>
 */
class KegiatanPosyanduFactory extends Factory
{
    protected $model = KegiatanPosyandu::class;

    public function definition(): array
    {
        // Membuat jam mulai acak antara jam 07:00 sampai 11:00 pagi (waktu umum Posyandu)
        $jamMulai = $this->faker->time('H:i');

        // Mengatur jam selesai otomatis 2 jam setelah jam mulai agar logis
        $jamSelesai = date('H:i', strtotime($jamMulai . ' +2 hours'));

        return [
            'nama_kegiatan' => $this->faker->sentence(3),
            'tanggal' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'lokasi' => $this->faker->address(),
            'deskripsi' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['terjadwal', 'berlangsung', 'selesai']),
            'user_id' => User::factory(),

            // Kolom tambahan untuk memperbaiki error integrasi database
            'jam_mulai' => $jamMulai,
            'jam_selesai' => $jamSelesai,
        ];
    }
}
