<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => 'USR' . $this->faker->unique()->numberBetween(1000, 9999),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'role' => $this->faker->randomElement(['admin', 'dosen', 'mahasiswa', 'koordinator']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'admin',
            ];
        });
    }

    public function dosen()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'dosen',
            ];
        });
    }

    public function mahasiswa()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'mahasiswa',
            ];
        });
    }
}