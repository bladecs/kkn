<?php
// database/seeders/KategoriLaporanSeeder.php
namespace Database\Seeders;

use App\Models\KategoriKegiatan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriLaporanSeeder extends Seeder
{
    public function run()
    {
        $kategori = [
            [
                'id_kategori' => 1,
                'nama' => 'Persiapan',
            ],
            [
                'id_kategori' => 2,
                'nama' => 'Observasi',
            ],
            [
                'id_kategori' => 3,
                'nama' => 'Koordinasi',
            ],
            [
                'id_kategori' => 4,
                'nama' => 'Pendidikan',
            ],
            [
                'id_kategori' => 5,
                'nama' => 'Kesehatan',
            ],
            [
                'id_kategori' => 6,
                'nama' => 'Lingkungan',
            ],
            [
                'id_kategori' => 7,
                'nama' => 'Ekonomi',
            ],
            [
                'id_kategori' => 8,
                'nama' => 'Dokumentasi',
            ],
            [
                'id_kategori' => 9,
                'nama' => 'Evaluasi',
            ],
            [
                'id_kategori' => 10,
                'nama' => 'Lainnya',
            ]
        ];

        foreach ($kategori as $item) {
            KategoriKegiatan::create($item);
        }
    }
}
