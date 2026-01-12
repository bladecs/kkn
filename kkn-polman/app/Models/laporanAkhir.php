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
        'kelompok_id',
        'anggota_id',
        'path_pdf',
        'path_ppt',
        'catatan',
        'comment',
        'link_tambahan',
        'nilai',
        'status',
    ];

    // Relationships
    public function anggota()
    {
        return $this->belongsTo(AnggotaKelompok::class, 'anggota_id');
    }

    public function kelompok()
    {
        return $this->belongsTo(KelompokKkn::class, 'kelompok_id', 'id_kelompok');
    }
}