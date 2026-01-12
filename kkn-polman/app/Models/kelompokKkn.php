<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokKkn extends Model
{
    use HasFactory;

    protected $table = 'kelompok_kkn';
    protected $primaryKey = 'id_kelompok';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_kelompok',
        'pembimbing',
        'created_by',
        'status',
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function pembimbingDosen()
    {
        return $this->belongsTo(Dosen::class, 'pembimbing', 'nip');
    }

    public function detailKelompok()
    {
        return $this->hasMany(DetailKelompokKkn::class, 'kelompok_id','id_kelompok');
    }

    public function anggotaKelompok()
    {
        return $this->hasMany(AnggotaKelompok::class, 'kelompok_id','id_kelompok');
    }
}