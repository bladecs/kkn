<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Jurusan;

class ProdiFactory extends Factory
{
    public function definition(): array
    {
        // Mapping prodi berdasarkan jurusan
        $prodiByJurusan = [
            'Manufacturing Engineering' => [
                'D3 Pemeliharaan Mesin',
                'D3 Teknologi Pembuatan Perkakas Presisi',
                'D3 Teknologi Manufaktur',
                'D4 Teknologi Rekayasa Manufaktur',
                'D4 Manajemen Teknologi Rekayasa',
            ],

            'Design Engineering' => [
                'D3 Teknologi Perancangan Perkakas Presisi',
                'D4 Teknologi Rekayasa Perancangan Manufaktur',
                'D4 Rekayasa Perancangan Mekanik',
            ],

            'Foundry Engineering' => [
                'D3 Teknologi Pengecoran Logam',
                'D4 Teknologi Rekayasa Material Maju',
            ],

            'Automation Engineering' => [
                'D4 Teknologi Rekayasa Mekatronika',
                'D4 Teknologi Rekayasa Otomasi',
                'D4 Teknologi Rekayasa Informatika Industri',
            ],
        ];

        // Generate jurusan menggunakan factory
        $jurusan = Jurusan::factory()->create();

        // Ambil daftar prodi sesuai jurusan
        $prodiList = $prodiByJurusan[$jurusan->nama_jurusan];

        return [
            'id_prodi' => 'PRO' . $this->faker->unique()->numberBetween(100, 999),
            'jurusan_id' => $jurusan->id_jurusan,
            'nama_prodi' => $this->faker->randomElement($prodiList),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
