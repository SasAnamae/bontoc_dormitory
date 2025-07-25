<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewReservationNotification extends Notification
{
    use Queueable;

    protected $reservation;

    /**
     * Create a new notification instance.
     */
    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['database']; // Only use database notifications
    }

    /**
     * Store notification in the database.
     */
   public function toDatabase($notifiable)
    {
        return [
            'message' => $this->reservation->user->name . ' has requested a reservation.',
            'url' => route('admin.reservations.index'), // Redirect to reservations page
        ];
    }
}
