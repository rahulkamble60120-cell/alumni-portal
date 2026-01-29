<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $primaryKey = 'application_id';

    // THIS IS THE LINE THAT FIXES YOUR ERROR
    protected $fillable = [
        'job_id',
        'user_id',
        'status'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function job()
    {
        return $this->belongsTo(JobPost::class, 'job_id');
    }
}