<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPendaftaranKkn extends Model
{
    use HasFactory;

    protected $table = 'detail_pendaftaran_kkn';
    protected $primaryKey = 'id_detail_pendaftaran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_detail_pendaftaran',
        'no_pendaftaran',
        'ipk',
        'kloter',
        'semester',
    ];

    protected $casts = [
        'tgl' => 'datetime',
    ];

    // Relationships
    public function pendaftaran()
    {
        return $this->belongsTo(PendaftaranKkn::class, 'no_pendaftaran', 'id_pendaftaran');
    }
}