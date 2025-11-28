<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JurusanFactory extends Factory
{
    public function definition(): array
    {
        $jurusanList = [
            'Automatin Engineering','Desain Engineering','Manufactur Engineering','Foundry Engineering'
        ];

        return [
            'id_jurusan' => 'JUR' . $this->faker->unique()->numberBetween(100, 999),
            'nama_jurusan' => $this->faker->randomElement($jurusanList),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}