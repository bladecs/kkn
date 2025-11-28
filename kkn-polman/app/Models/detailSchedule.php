<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSchedule extends Model
{
    use HasFactory;

    protected $table = 'detail_schedule';
    protected $primaryKey = 'id_detail_schedule';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_detail_schedule',
        'kloter',
        'schedule_id',
        'deskripsi',
        'tgl_mulai',
        'tgl_selesai',
    ];

    protected $casts = [
        'tgl_mulai' => 'datetime',
        'tgl_selesai' => 'datetime',
    ];

    // Relationships
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'kode_kegiatan');
    }
}