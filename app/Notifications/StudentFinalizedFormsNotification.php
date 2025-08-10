<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class StudentFinalizedFormsNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $student;

    /**
     * Create a new notification instance.
     */
    public function __construct($student)
    {
        $this->student = $student;
    }

    /**
     * Notification channels.
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Format the notification for the database.
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => "{$this->student->name} has submitted their Occupant Profile.",
            'url' => route('admin.applications.show', $this->student->id),
        ];
    }
}
