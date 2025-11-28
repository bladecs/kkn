<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\Jurusan;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil prodi dan jurusan pertama yang sudah dibuat oleh JurusanProdiSeeder
        $firstJurusan = Jurusan::first();
        $firstProdi = Prodi::first();

        // 1 akun KOORDINATOR
        $userKoordinator = User::factory()->create([
            'id' => 'USRKOOR01',
            'email' => 'koordinator@example.com',
            'password' => bcrypt('password'),
            'role' => 'koordinator',
        ]);

        // Buat identitas koordinator di tabel dosen
        Dosen::create([
            'id' => $userKoordinator->id,
            'nip' => fake()->unique()->numberBetween(1000000000, 1999999999),
            'name' => 'Koordinator Utama',
            'prodi_id' => $firstProdi->id_prodi,
            'jurusan_id' => $firstJurusan->id_jurusan,
        ]);

        // 1 akun DOSEN
        $userDosen = User::factory()->create([
            'id' => 'USRDSN01',
            'email' => 'dosen@example.com',
            'password' => bcrypt('password'),
            'role' => 'dosen',
        ]);

        // Buat identitas dosen di tabel dosen
        Dosen::create([
            'id' => $userDosen->id,
            'nip' => fake()->unique()->numberBetween(1000000000, 1999999999),
            'name' => 'Dosen Utama',
            'prodi_id' => $firstProdi->id_prodi,
            'jurusan_id' => $firstJurusan->id_jurusan,
        ]);
    }
}
