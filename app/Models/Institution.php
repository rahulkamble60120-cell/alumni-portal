<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    // SRS Source: 216 - Define the primary key
    protected $primaryKey = 'institution_id';

    // These are the fields we are allowed to save
    protected $fillable = [
        'name',
        'subdomain',
        'brand_logo',
    ];

    // Relationship: One Institution has many Departments
    public function departments()
    {
        return $this->hasMany(Department::class, 'institution_id');
    }

    // Relationship: One Institution has many Users
    public function users()
    {
        return $this->hasMany(User::class, 'institution_id');
    }
}