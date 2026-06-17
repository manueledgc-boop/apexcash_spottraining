<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CertificationAttempt extends Model
{
    protected $fillable = [
        'user_id',
        'attempt_number',

        'total_questions',
        'total_correct',
        'total_wrong',
        'global_score',

        'preflop_total',
        'preflop_correct',
        'preflop_score',

        'flop_total',
        'flop_correct',
        'flop_score',

        'turn_total',
        'turn_correct',
        'turn_score',

        'river_total',
        'river_correct',
        'river_score',

        'mastery_total',
        'mastery_correct',
        'mastery_score',

        'passed',
        'distinction',
        'result_label',
        'certificate_code',

        'questions_snapshot',
        'answers_snapshot',

        'started_at',
        'completed_at',
        'next_attempt_at',
    ];

    protected $casts = [
        'passed' => 'boolean',
        'distinction' => 'boolean',

        'questions_snapshot' => 'array',
        'answers_snapshot' => 'array',

        'global_score' => 'float',
        'preflop_score' => 'float',
        'flop_score' => 'float',
        'turn_score' => 'float',
        'river_score' => 'float',
        'mastery_score' => 'float',

        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'next_attempt_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isCompleted(): bool
    {
        return $this->completed_at !== null;
    }

    public function isLockedForRetry(): bool
    {
        return ! $this->passed
            && $this->next_attempt_at !== null
            && now()->lt($this->next_attempt_at);
    }

    public function resultBadge(): string
    {
        if (! $this->isCompleted()) {
            return 'En progreso';
        }

        if ($this->distinction) {
            return 'Aprobado con Distinción';
        }

        if ($this->passed) {
            return 'Aprobado';
        }

        return 'No aprobado';
    }
}