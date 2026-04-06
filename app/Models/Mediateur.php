<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mediateur extends Model
{
    protected $fillable = [
        'user_id',
        'zonesCouvertes',
    ];

    protected $casts = [
        'zonesCouvertes' => 'json',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
