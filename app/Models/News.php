<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'content', 'image', 
        'institution_id', 'department_id', 'chapter_id'
    ];

    // Optional: Auto-generate slug when saving (simple version)
    public static function boot() {
        parent::boot();
        static::creating(function ($news) {
            $news->slug = \Str::slug($news->title) . '-' . time();
        });
    }
}