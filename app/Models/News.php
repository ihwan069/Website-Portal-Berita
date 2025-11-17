<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    protected $fillable = [
        'author_id',
        'news_category_id',
        'title',
        'slug',
        'thumbnail',
        'content',
        'is_featured',
        'is_published',
        'published_at',
        'meta_description'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function getShortTitleAttribute()
    {
        return Str::limit($this->title, 30);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function newsCategory(): BelongsTo
    {
        return $this->belongsTo(newsCategory::class);
    }

    public function banner(): HasOne
    {
        return $this->hasOne(Banner::class);
    }
}
