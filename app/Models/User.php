<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // MANDATORY: Tells Laravel to use user_id instead of 'id'
    protected $primaryKey = 'user_id'; 
    public $incrementing = true;

    protected $fillable = [
        'institution_id', 'name', 'email', 'password', 'usn',
        'graduation_year', 'role', 'status', 'department_id', 
        'chapter_id', 'current_company', 'current_position'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return ['email_verified_at' => 'datetime', 'password' => 'hashed'];
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id', 'chapter_id');
    }
}