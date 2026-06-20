<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HandLabSpot extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'format',
        'street',
        'spot_type',
        'normalized_signature',
        'hero_position',
        'villain_position',
        'hero_cards',
        'board_cards',
        'pot_bb',
        'spr',
        'effective_stack_bb',
        'action_history',
        'active_players',
        'options',
        'selected_action',
        'best_action',
        'gto_explanation',
        'exploit_explanation',
        'concepts',
        'leak_label',
        'source_type',
        'visibility',
        'review_status',
        'analysis_status',
        'reviewed_at',
        'reviewed_by',
        'user_seen_at',
        'review_reason',
        'review_note',
        'matched_spot_id',
        'used_ai',
        'analysis_version',
        'raw_payload',
        'spot_family',
        'spot_family_label',
    ];

    protected $casts = [
        'hero_cards' => 'array',
        'board_cards' => 'array',
        'action_history' => 'array',
        'active_players' => 'array',
        'options' => 'array',
        'concepts' => 'array',
        'raw_payload' => 'array',
        'pot_bb' => 'decimal:2',
        'spr' => 'decimal:2',
        'effective_stack_bb' => 'decimal:2',
        'used_ai' => 'boolean',
        'reviewed_at' => 'datetime',
        'user_seen_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function matchedSpot(): BelongsTo
    {
        return $this->belongsTo(self::class, 'matched_spot_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
