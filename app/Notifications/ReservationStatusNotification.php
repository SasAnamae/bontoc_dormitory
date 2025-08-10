<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReservationStatusNotification extends Notification
{
    use Queueable;

    protected $reservation;
    protected $customMessage;
    protected $customUrl;

    /**
     * Create a new notification instance.
     */
    public function __construct($reservation = null, $customMessage = null, $customUrl = null)
    {
        $this->reservation = $reservation;
        $this->customMessage = $customMessage;
        $this->customUrl = $customUrl;
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
        // If reservation was passed (normal usage)
        if ($this->reservation) {
            $message = "Your reservation for {$this->reservation->bed->room->name}, {$this->reservation->bed->deck} {$this->reservation->bed->position} has been {$this->reservation->status}.";

            $url = null;
            if ($this->reservation->status === 'Approved') {
                $url = route('student.application.form');
            }

            return [
                'message' => $message,
                'reservation_id' => $this->reservation->id,
                'url' => $url,
            ];
        }

        return [
            'message' => $this->customMessage ?? 'Your reservation and forms have been reset. You may now reapply.',
        ];
    }
}

