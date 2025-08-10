<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class PaymentStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function via($notifiable)
    {
        return ['database']; // You can add 'mail' if you want email too
    }

    public function toDatabase($notifiable)
    {
        $status = $this->payment->status;
        $isVerified = $status === 'verified';

        return [
            'title' => $isVerified ? 'Payment Approved ✅' : 'Payment Rejected ❌',
            'message' => $isVerified
                ? 'Your payment of ₱' . number_format($this->payment->amount, 2) . ' has been approved.'
                : 'Your payment of ₱' . number_format($this->payment->amount, 2) . ' has been rejected. Please check and resubmit.',
            'payment_id' => $this->payment->id,
            'status' => $status,
        ];
    }
}

