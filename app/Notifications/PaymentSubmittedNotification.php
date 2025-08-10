<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class PaymentSubmittedNotification extends Notification
{
    use Queueable;

    public $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'payment_id' => $this->payment->id,
            'student_name' => $this->payment->user->full_name ?? 'Student',
            'amount' => $this->payment->amount,
            'message' => 'A new payment has been submitted and requires approval.',
            'url' => route('admin.payments.index', $this->payment->id),
        ]);
    }
}
