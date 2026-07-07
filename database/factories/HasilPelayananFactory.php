<?php

namespace Database\Factories;

use App\Models\HasilPelayanan;
use App\Models\KegiatanPosyandu;
use App\Models\Balita;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HasilPelayanan>
 */
class HasilPelayananFactory extends Factory
{
    protected $model = HasilPelayanan::class;

    public function definition(): array
    {
        return [
            'kegiatan_id' => KegiatanPosyandu::factory(),
            'balita_id' => Balita::factory(),
            'berat_badan' => $this->faker->randomFloat(2, 2, 20),
            'tinggi_badan' => $this->faker->randomFloat(2, 45, 120),
            'lingkar_kepala' => $this->faker->randomFloat(2, 30, 55),
            'status_gizi' => $this->faker->randomElement(['normal', 'kurang', 'buruk', 'lebih']),
            'imunisasi' => $this->faker->word(),
            'vitamin' => $this->faker->word(),
            'catatan' => $this->faker->sentence(),
            'user_id' => User::factory(),
        ];
    }
}
