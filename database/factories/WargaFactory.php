<?php

namespace Database\Factories;

use App\Models\Warga;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warga>
 */
class WargaFactory extends Factory
{
    protected $model = Warga::class;

    private static $nikCounter = 1000000000000001;

    public function definition(): array
    {
        return [
            'nik' => (string) self::$nikCounter++,
            'nama' => $this->faker->name(),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date(),
            'jenis_kelamin' => $this->faker->randomElement(['L', 'P']),
            'alamat' => $this->faker->address(),
            'no_telepon' => $this->faker->phoneNumber(),
            'user_id' => User::factory(),
        ];
    }
}
