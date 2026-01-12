<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailLogbook extends Model
{
    use HasFactory;

    protected $table = 'detail_logbook';
    protected $primaryKey = 'id_detail_logbook';
    protected $keyType = 'string';

    protected $fillable = [
        'id_detail_logbook',
        'logbook_id',
        'nama_kegiatan',
        'kategori_id',
        'deskripsi_kegiatan',
        'jumlah_waktu',
    ];

    // Relationships
    public function logbook()
    {
        return $this->belongsTo(LogbookKegiatan::class, 'logbook');
    }

    public function kategoriKegiatan()
    {
        return $this->belongsTo(KategoriKegiatan::class, 'kategori');
    }
}