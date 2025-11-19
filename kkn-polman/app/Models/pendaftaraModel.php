<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pendaftaraModel extends Model
{
    use HasFactory;
    protected $table = 'pendaftaran_kkn';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nim',
        'name',
        'ipk',
        'sks',
        'semester',
        'jurusan',
        'study_program',
        'status',
        'ktm_path',
        'photo_path',
        'proposal_path',
        'rab_path',
        'project_kkn',
        'no_tlp',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'nim', 'nim');
    }
}