<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiKkn extends Model
{
    use HasFactory;

    protected $table = 'lokasi_kkn';
    protected $primaryKey = 'id_lokasi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_lokasi',
        'nama_lokasi',
        'alamat',
        'kota',
        'provinsi',
    ];

    // Relationships
    public function projects()
    {
        return $this->hasMany(ProjectKkn::class, 'lokasi_id');
    }
}