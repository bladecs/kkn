<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSchema extends Model
{
    use HasFactory;

    protected $table = 'detail_schemas';
    protected $primaryKey = 'id_detail_schema';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_detail_schema',
        'schedule_id',
        'schema_id',
        'kategori_id',
        'kuota',
        'tgl_mulai',
        'tgl_selesai',
    ];

    protected $casts = [
        'tgl_mulai' => 'datetime',
        'tgl_selesai' => 'datetime',
    ];

    // Relationships
    public function schema()
    {
        return $this->belongsTo(Schema::class, 'schema_id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriSchema::class, 'kategori_id');
    }
}