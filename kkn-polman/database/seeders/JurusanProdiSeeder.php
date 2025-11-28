<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;
use App\Models\Prodi;

class JurusanProdiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

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

        foreach ($data as $jurusanName => $prodiList) {

            $jurusan = Jurusan::create([
                'id_jurusan' => 'JUR' . rand(100, 999),
                'nama_jurusan' => $jurusanName
            ]);

            foreach ($prodiList as $prodiName) {
                Prodi::create([
                    'id_prodi' => 'PRO' . rand(100, 999),
                    'jurusan_id' => $jurusan->id_jurusan,
                    'nama_prodi' => $prodiName,
                ]);
            }
        }
    }
}
