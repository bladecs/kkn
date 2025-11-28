<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKelompokKkn extends Model
{
    use HasFactory;

    protected $table = 'detail_kelompok_kkn';
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'kelompok',
        'project',
        'jumlah_anggota',
        'tgl_mulai',
        'tgl_selesai',
    ];

    protected $casts = [
        'tgl_mulai' => 'datetime',
        'tgl_selesai' => 'datetime',
    ];

    // Relationships
    public function kelompok()
    {
        return $this->belongsTo(KelompokKkn::class, 'kelompok');
    }

    public function project()
    {
        return $this->belongsTo(ProjectKkn::class, 'project');
    }
}