<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReviewReceived extends Notification
{
    use Queueable;

    protected $reviewerName;
    protected $note;
    protected $artisanId;

    public function __construct($reviewerName, $note, $artisanId)
    {
        $this->reviewerName = $reviewerName;
        $this->note = $note;
        $this->artisanId = $artisanId;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => "{$this->reviewerName} left you a {$this->note}-star review!",
            'url' => route('artisan.profile', ['id' => $this->artisanId]),
            'type' => 'review',
        ];
    }
}
