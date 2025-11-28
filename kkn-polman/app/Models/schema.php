<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schema extends Model
{
    use HasFactory;

    protected $table = 'schemas';
    protected $primaryKey = 'id_schema';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_schema',
        'schedule_id',
        'approved_by',
        'created_by',
    ];

    // Relationships
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function detailSchemas()
    {
        return $this->hasMany(DetailSchema::class, 'schema_id');
    }
}