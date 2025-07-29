<?php

namespace App\Notifications;

use App\Models\StudentReport;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewStudentReportNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $report;

    public function __construct(StudentReport $report)
    {
        $this->report = $report;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Student Report Submitted',
            'message' => $this->report->title,
            'report_id' => $this->report->id,
            'student_name' => $this->report->student->name,
            'url' => route('admin.reports.show', $this->report->id)
        ];
    }
}
