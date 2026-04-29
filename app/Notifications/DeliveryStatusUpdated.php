<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DeliveryStatusUpdated extends Notification
{
    use Queueable;

    protected $deliveryId;
    protected $statusLabel;

    /**
     * Create a new notification instance.
     */
    public function __construct($deliveryId, $statusLabel)
    {
        $this->deliveryId = $deliveryId;
        $this->statusLabel = $statusLabel;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => "Delivery #{$this->deliveryId} status updated to: {$this->statusLabel}",
            'url' => route('dashboard'), // We can point to the dashboard where they track deliveries
            'type' => 'delivery',
        ];
    }
}
