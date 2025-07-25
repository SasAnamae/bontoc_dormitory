<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReservationStatusNotification extends Notification
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
     * Notification channels.
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Format notification for database.
     */
    public function toDatabase($notifiable)
    {
        $message = "Your reservation for {$this->reservation->bed->room->name}, {$this->reservation->bed->deck} {$this->reservation->bed->position} has been {$this->reservation->status}.";

        // If status is Approved, add link to fill-up profile form
        $url = null;
        if ($this->reservation->status === 'Approved') {
            $url = route('student.profile.create');
        }

        return [
            'message' => $message,
            'reservation_id' => $this->reservation->id,
            'url' => $url, 
        ];
    }
}
