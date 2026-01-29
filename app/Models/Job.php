<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    // We removed 'job_id' here because your database uses 'id'
    protected $fillable = [
        'title', 
        'company', 
        'location', 
        'type', 
        'description', 
        'user_id', 
        'institution_id'
    ];
}