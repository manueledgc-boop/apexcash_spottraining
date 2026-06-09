<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSpotStat extends Model
{
    protected $fillable = [
        'user_id',
        'spot_id',
        'module',

        'spot_title',
        'hero_cards',

        'total',
        'correct',
        'wrong',
        'accuracy',

        'last_seen_at',
        'last_wrong_at',
        'family',
        'family_label',
        'concept',
        'concept_label',
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
        'last_wrong_at' => 'datetime',
    ];
}