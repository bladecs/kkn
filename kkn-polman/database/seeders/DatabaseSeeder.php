<?php

namespace Database\Seeders;

use App\Models\dosenModel;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        dosenModel::factory()->create([
            'name' => 'koor1',
            'email' => 'koordinator@gmail.com',
            'nip' => '1234567890',
            'phone' => '081234567890',
            'jurusan' => 'ae',
            'study_program' => 'Teknik Rekayasa Informatika Industri',
            'role' => 'koordinator',
            'password' => bcrypt('password'),
        ]);

        dosenModel::factory()->create([
            'name' => 'dosen1',
            'email' => 'dosen@gmail.com',
            'nip' => '9876543210',
            'phone' => '089876543210',
            'jurusan' => 'ae',
            'study_program' => 'Teknik Rekayasa Informatika Industri',
            'role' => 'dosen',
            'password' => bcrypt('password'),
        ]);
    }
}
