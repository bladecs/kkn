<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Prodi;
use App\Models\Jurusan;
use App\Models\User;

class DosenFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nip' => $this->faker->unique()->numberBetween(1000000000, 1999999999),
            'id'=> $this->faker->name(),
            'name' => $this->faker->name(),
            'prodi_id' => Prodi::factory(),
            'jurusan_id' => Jurusan::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}