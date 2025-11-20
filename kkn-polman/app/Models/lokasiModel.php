<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lokasiModel extends Model
{
    use HasFactory;
    protected $table = 'lokasi';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'nama_lokasi',
        'kota',
        'provinsi',
        'jalan',
        'alamat',
    ];
}
