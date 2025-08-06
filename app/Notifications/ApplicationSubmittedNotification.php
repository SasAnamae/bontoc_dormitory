<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\User;

class ApplicationSubmittedNotification extends Notification
{
    use Queueable;

    protected $student;

    public function __construct(User $student)
    {
        $this->student = $student;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Student Payment Submitted',
            'message' => "{$this->student->name} has completed their payment and is awaiting admin approval.",
            'student_id' => $this->student->id,
            'url' => route('admin.applications.show', $this->student->id)
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Student Payment Submitted',
            'message' => "{$this->student->name} has completed their payment and is awaiting admin approval.",
            'student_id' => $this->student->id,
            'url' => route('admin.applications.show', $this->student->id)
        ];
    }
}
