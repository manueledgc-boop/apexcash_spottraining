<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLeak extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'module',
        'module_label',
        'total',
        'correct',
        'accuracy',
        'mistakes',
        'blunders',
        'weakness_score',
        'last_mistake_at',
    ];

    protected $casts = [
        'accuracy' => 'decimal:2',
        'weakness_score' => 'decimal:2',
        'last_mistake_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
