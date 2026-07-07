<?php

namespace Database\Factories;

use App\Models\Balita;
use App\Models\Warga;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Balita>
 */
class BalitaFactory extends Factory
{
    protected $model = Balita::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'tanggal_lahir' => $this->faker->date(),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'warga_id' => Warga::factory(),
        ];
    }
}
