<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnggotaKelompok extends Model
{
    use HasFactory;

    protected $table = 'anggota_kelompok';
    protected $primaryKey = 'id_anggota';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_anggota',
        'nim',
        'kelompok_id',
        'role_anggota',
    ];

    // Relationships
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim');
    }

    public function kelompok()
    {
        return $this->belongsTo(KelompokKkn::class, 'kelompok_id');
    }

    public function logbooks()
    {
        return $this->hasMany(LogbookKegiatan::class, 'anggota');
    }

    public function laporanAkhir()
    {
        return $this->hasMany(LaporanAkhir::class, 'anggota');
    }
}