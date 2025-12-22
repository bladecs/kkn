<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nim',
        'name',
        'semester',
        'prodi_id',
        'jurusan_id',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function pendaftaranKkn()
    {
        return $this->hasMany(PendaftaranKkn::class, 'nim');
    }

    public function anggotaKelompok()
    {
        return $this->hasMany(AnggotaKelompok::class, 'nim');
    }
}