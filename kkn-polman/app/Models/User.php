<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function schedulesCreated()
    {
        return $this->hasMany(Schedule::class, 'created_by');
    }

    public function schemasApproved()
    {
        return $this->hasMany(Schema::class, 'approved_by');
    }

    public function schemasCreated()
    {
        return $this->hasMany(Schema::class, 'created_by');
    }

    public function projectsApproved()
    {
        return $this->hasMany(ProjectKkn::class, 'approved_by');
    }

    public function kelompokCreated()
    {
        return $this->hasMany(KelompokKkn::class, 'created_by');
    }

    public function mahasiswa(){
        return $this->hasOne(Mahasiswa::class, 'id', 'id');
    }
}
