<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'training_session_id',
        'spot_id',
        'module',
        'module_label',
        'title',
        'hero_position',
        'villain_position',
        'hero_cards',
        'selected_action',
        'correct_action',
        'grade',
        'is_correct',
        'frequency',
        'ev_score',
        'xp_earned',
        'explanation',
        'spot_snapshot',
    ];

    protected $casts = [
        'hero_cards' => 'array',
        'spot_snapshot' => 'array',
        'is_correct' => 'boolean',
        'frequency' => 'integer',
        'ev_score' => 'integer',
        'xp_earned' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function trainingSession(): BelongsTo
    {
        return $this->belongsTo(TrainingSession::class);
    }
}
