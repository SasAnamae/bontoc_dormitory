<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class NewAnnouncementNotification extends Notification
{
    use Queueable;

    protected $announcement;

    public function __construct($announcement)
    {
        $this->announcement = $announcement;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Announcement',
            'message' => Str::limit(strip_tags($this->announcement->message), 100),
            'announcement_id' => $this->announcement->id,
            'url' => route('audience.show', $this->announcement->id),
        ];
    }
}

