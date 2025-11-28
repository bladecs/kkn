<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ScheduleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id_kegiatan' => 'SCH' . $this->faker->unique()->numberBetween(1000, 9999),
            'created_by' => User::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}