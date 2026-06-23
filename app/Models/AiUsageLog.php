<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiUsageLog extends Model
{
    protected $fillable = [
        'user_id',
        'feature',
        'used_on',
        'count',
    ];

    protected $casts = [
        'used_on' => 'date',
    ];
}
