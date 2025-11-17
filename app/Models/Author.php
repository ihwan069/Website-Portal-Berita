<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    protected $fillable = [
        'user_id',
        'username',
        'avatar',
        'bio'
    ];

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
