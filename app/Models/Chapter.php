<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    // These are the fields we allow the user to fill in
    protected $fillable = [
        'institution_id', 
        'name', 
        'city'
    ];
    
    // Relationship: A Chapter has many Users (Admins/Alumni)
    public function users()
    {
        return $this->hasMany(User::class);
    }
}