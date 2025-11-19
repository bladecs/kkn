<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projectModel extends Model
{
    use HasFactory;
    protected $table = 'project_kkn';
    protected $fillable = [
        'id',
        'nim',
        'nip',
        'judul_project',
        'deskripsi_project',
        'lokasi',
        'kota',
        'provinsi',
        'jalan',
        'alamat',
        'proposal_kkn_path',
        'rab_kkn_path',
        'penyetuju',
        'status',
        'jumlah_anggota',
    ];
}
