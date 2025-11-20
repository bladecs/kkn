<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengelompokanModel extends Model
{
    use HasFactory;
    protected $table = 'pengelompokan';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'nip',
        'id_lokasi',
        'id_project',
        'nama_kelompok',
        'jumlah_anggota',
        'koordinator',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
    ];

    public function project()
    {
        return $this->hasOne(projectModel::class, 'id', 'id_project');
    }

    public function lokasi()
    {
        return $this->hasOne(lokasiModel::class, 'id', 'id_lokasi');
    }

    public function dosen()
    {
        return $this->hasOne(dosenModel::class, 'nip', 'nip');
    }
}
