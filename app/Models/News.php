<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'image_link',
        'author',
        'metadata',
        'url',
        'published_at',
        'category',
        'source',
        'url_hash'
    ];
}
