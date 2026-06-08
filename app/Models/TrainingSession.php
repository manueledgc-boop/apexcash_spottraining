<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mode',
        'module',
        'total_spots',
        'correct_spots',
        'wrong_spots',
        'accuracy',
        'xp_earned',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'accuracy' => 'decimal:2',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(TrainingResult::class);
    }
}
