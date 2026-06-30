<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FounderApplication extends Model
{
    protected $fillable = [
        'user_id',
        'country',
        'poker_experience',
        'main_format',
        'usual_level',
        'motivation',
        'expectations',
        'willing_to_give_feedback',
        'status',
        'reviewed_at',
        'reviewed_by',
    ];

    protected $casts = [
        'willing_to_give_feedback' => 'boolean',
        'reviewed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}