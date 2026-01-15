<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_id',
        'external_id',
        'title',
        'description',
        'content',
        'author',
        'category',
        'url',
        'image_url',
        'published_at',
    ];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
