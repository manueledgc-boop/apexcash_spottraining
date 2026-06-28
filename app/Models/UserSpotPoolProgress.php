<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSpotPoolProgress extends Model
{
    protected $table = 'user_spot_pool_progress';

    protected $fillable = [
        'user_id',
        'stage',
        'pool_key',
        'spot_id',
        'cycle',
        'seen_at',
    ];

    protected $casts = [
        'seen_at' => 'datetime',
    ];
}