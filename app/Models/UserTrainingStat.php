<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTrainingStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'module',
        'module_label',
        'total_spots',
        'correct_spots',
        'wrong_spots',
        'best',
        'good',
        'marginal',
        'mistake',
        'blunder',
        'accuracy',
        'xp',
        'level',
    ];

    protected $casts = [
        'accuracy' => 'decimal:2',
        'xp' => 'integer',
        'level' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
