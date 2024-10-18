<?php

namespace App\Models;

use App\Models\Video;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    public $casts = [            # we say learnings is an array
        'learnings' =>'array',
    ];

    public function scopeReleased(Builder $query): Builder
    {
        return $query->whereNotNull('released_at');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }
}
