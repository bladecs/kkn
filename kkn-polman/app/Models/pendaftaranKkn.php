<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranKkn extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_kkn';
    protected $primaryKey = 'id_pendaftaran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pendaftaran',
        'nim',
        'status',
    ];

    // Relationships
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim');
    }

    public function detailPendaftaran()
    {
        return $this->hasMany(DetailPendaftaranKkn::class, 'no_pendaftaran', 'id_pendaftaran');
    }
}