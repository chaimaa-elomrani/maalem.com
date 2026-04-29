<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mediateur extends Model
{
    protected $fillable = [
        'user_id',
        'zonesCouvertes',
        'bio',
        'vehicleType',
        'disponibility',
    ];

    protected $casts = [
        'zonesCouvertes' => 'json',
        'disponibility' => 'json',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function deliveryRequests()
    {
        return $this->hasMany(DeliveryRequest::class);
    }
}
