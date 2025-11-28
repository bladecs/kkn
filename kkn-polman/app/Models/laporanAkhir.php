<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanAkhir extends Model
{
    use HasFactory;

    protected $table = 'laporan_akhir';
    protected $primaryKey = 'id_laporan_akhir';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_laporan_akhir',
        'anggota_id',
        'path',
        'nilai',
        'status',
    ];

    // Relationships
    public function anggota()
    {
        return $this->belongsTo(AnggotaKelompok::class, 'anggota_id');
    }
}