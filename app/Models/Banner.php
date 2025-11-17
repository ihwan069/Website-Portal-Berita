<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Banner extends Model
{
    protected $fillable = [
        'news_id'
    ];

    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }
}
