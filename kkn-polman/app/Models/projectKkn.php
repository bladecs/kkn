<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectKkn extends Model
{
    use HasFactory;

    protected $table = 'project_kkn';
    protected $primaryKey = 'id_project';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_project',
        'judul',
        'deskripsi',
        'lokasi_id',
        'pengaju',
        'status',
        'approved_by',
    ];

    // Relationships
    public function lokasi()
    {
        return $this->belongsTo(LokasiKkn::class, 'lokasi_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function detailKelompok()
    {
        return $this->hasMany(DetailKelompokKkn::class, 'project_id');
    }
}