<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogbookKegiatan extends Model
{
    use HasFactory;

    protected $table = 'logbook_kegiatan';
    protected $primaryKey = 'id_logbook';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_logbook',
        'anggota_id',
        'nilai',
        'status',
        'week',
    ];

    // Relationships
    public function anggota()
    {
        return $this->belongsTo(AnggotaKelompok::class, 'anggota_id');
    }

    public function detailLogbooks()
    {
        return $this->hasMany(DetailLogbook::class, 'logbook_id');
    }
}