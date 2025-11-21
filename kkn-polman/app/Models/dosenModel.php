<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class dosenModel extends Authenticatable
{
    use HasFactory;
    protected $table = 'dosen';
    protected $fillable = [
        'name',
        'nip',
        'email',
        'phone',
        'jurusan',
        'study_program',
        'role',
        'password',
    ];

    public function project()
    {
        return $this->hasOne(projectModel::class, 'nip', 'nip');
    }
}
