<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    // SRS Source: 226
    protected $primaryKey = 'department_id';

    protected $fillable = [
        'institution_id',
        'name',
        'code',
    ];

    // Relationship: A department belongs to ONE Institution
    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }
}