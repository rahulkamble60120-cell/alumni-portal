<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    protected $primaryKey = 'job_id';

    protected $fillable = [
        'institution_id',
        'user_id',
        'title',
        'company_name',
        'location',
        'description',
        'apply_link'
    ];

    // Link to the user who posted it (Admin)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Link to Applications (Day 14 - NEW)
    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_id');
    }
}