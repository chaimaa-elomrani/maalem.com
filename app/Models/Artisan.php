<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Artisan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'workingArea',
        'service',
        'disponibility',
        'experience',
        'certifications',
        'workshopAdresse',
        'status',
        'access_type',
        'noteMoyenne',
    ];

    protected $casts = [
        'disponibility' => 'json',
        'certifications' => 'json',
        'noteMoyenne' => 'float',
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
