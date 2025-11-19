<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\dosenModel>
 */
class dosenModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'nip' => $this->faker->unique()->numerify('##########'),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->numerify('08##########'),
            'jurusan' => $this->faker->randomElement(['ae', 'ti', 'si', 'te']),
            'study_program' => $this->faker->randomElement([
                'Teknik Rekayasa Informatika Industri',
            ]),
            'role' => 'dosen',
            'password' => bcrypt('password'),
        ];
    }
}
