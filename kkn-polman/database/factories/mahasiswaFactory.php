<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Prodi;
use App\Models\Jurusan;

class MahasiswaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nim' => $this->faker->unique()->numberBetween(2000000000, 2099999999),
            'name' => $this->faker->name(),
            'semester' => $this->faker->numberBetween(1, 8),
            'prodi_id' => Prodi::factory(),
            'jurusan_id' => Jurusan::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function semester(int $semester)
    {
        return $this->state(function (array $attributes) use ($semester) {
            return [
                'semester' => $semester,
            ];
        });
    }
}