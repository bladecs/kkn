<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusan';
    protected $primaryKey = 'id_jurusan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_jurusan',
        'nama_jurusan',
    ];

    // Relationships
    public function prodi()
    {
        return $this->hasMany(Prodi::class, 'jurusan_id');
    }

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'jurusan_id');
    }

    public function dosen()
    {
        return $this->hasMany(Dosen::class, 'jurusan_id');
    }
}