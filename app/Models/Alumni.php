<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Alumni extends Model
{
    use HasFactory;

    // 1. Force this model to use the 'users' table
    protected $table = 'users';
    
    // 2. Since 'users' uses 'user_id' as the key, we might need to specify it
    protected $primaryKey = 'user_id';

    // 3. Allow these fields to be filled
    protected $fillable = [
        'name', 'email', 'password', 'institution_id', 'role', 
        'graduation_year', 'current_company', 'linkedin_url'
    ];

    // 4. AUTOMATIC FILTER: When we ask for Alumni, don't show the Admin!
    protected static function booted()
    {
        static::addGlobalScope('alumni_only', function (Builder $builder) {
            $builder->where('role', '!=', 'admin');
        });
    }
}