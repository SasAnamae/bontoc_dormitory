<?php

namespace App\Notifications;

use App\Models\StudentReport;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReportResponded extends Notification implements ShouldQueue
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
            'title' => 'Your Report Has Been Responded To',
            'message' => $this->report->admin_response ?? 'The admin has replied to your report.',
            'report_id' => $this->report->id,
            'status' => $this->report->status,
            'url' => route('student.report.show', $this->report->id),
        ];
    }
}
