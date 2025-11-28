<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriSchema extends Model
{
    use HasFactory;

    protected $table = 'kategori_schema';
    protected $primaryKey = 'id_kategori';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_kategori',
        'deskripsi',
    ];

    // Relationships
    public function detailSchemas()
    {
        return $this->hasMany(DetailSchema::class, 'kategori_id');
    }
}