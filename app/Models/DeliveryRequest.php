<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'artisan_id',
        'mediateur_id',
        'description',
        'status',
        'deliveryDate',
        'adresse'
    ];

    // Status Constants
    const STATUS_PENDING = 'pending';
    const STATUS_ACCEPTED_BY_MEDIATOR = 'accepted_by_mediateur';
    const STATUS_PICKED_UP_CLIENT = 'picked_up_client';
    const STATUS_AT_ARTISAN = 'at_artisan';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_READY_FOR_RETURN = 'ready_for_return';
    const STATUS_DELIVERED = 'delivered';

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function artisan()
    {
        return $this->belongsTo(Artisan::class);
    }

    public function mediateur()
    {
        return $this->belongsTo(Mediateur::class);
    }

    public function getStatusLabelAttribute()
    {
        return str_replace('_', ' ', ucfirst($this->status));
    }
}
