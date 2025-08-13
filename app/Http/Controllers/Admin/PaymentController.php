<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Notifications\PaymentStatusNotification;

class PaymentController extends Controller
{
    /**
     * Show the payment summary grouped by student.
     */
   public function index()
    {
        $payments = Payment::with(['user.reservations.room.dormitory'])
            ->orderByDesc('paid_at')
            ->paginate(20);

        foreach ($payments as $payment) {
            // Get reservation details
            $reservation = $payment->user->reservations->first();
            $payment->room_name = $reservation?->room?->name;
            $payment->dorm_name = $reservation?->room?->dormitory?->name;

            // Expected = dorm fee (500) + appliance fee
            $expectedAmount = 500 + ($payment->appliance_fee ?? 0);

            // Balance
            $payment->balance = max($expectedAmount - $payment->amount, 0);

            // Payment status
            if ($payment->balance == 0) {
                $payment->payment_status = 'Paid';
            } elseif ($payment->paid_at && \Carbon\Carbon::parse($payment->paid_at)->lt(now()->subMonth())) {
                $payment->payment_status = 'Overdue';
            } else {
                $payment->payment_status = 'Partial';
            }
        }

        return view('admin.payments.index', compact('payments'));
    }




    public function verify(Payment $payment)
    {
        $payment->status = 'verified';
        $payment->save();

        // Optional: notify student
        $payment->user->notify(new \App\Notifications\PaymentStatusNotification($payment));

        return redirect()->back()->with('success', 'Payment verified successfully.');
    }

    /**
     * Show the payment logs (all recorded payments).
     */
    public function logs()
    {
         $payments = Payment::with(['user'])
        ->where('status', 'verified')
        ->orderByDesc('paid_at')
        ->paginate(20);

        return view('admin.payments.logs', compact('payments'));
    }


    /**
     * Export payment overview (grouped per student).
     */
    public function export(Request $request)
    {
        $fileName = $request->query('filename', 'admin_payments_overview') . '.xlsx';
       
        $payments = Payment::with(['user'])
            ->where('status', 'verified')
            ->orderByDesc('paid_at')
            ->get();
        return Excel::download(new PaymentsExport($payments), $fileName);
    }

    /**
     * Export payment logs (detailed).
     */
    public function exportLogs(Request $request)
    {
        $fileName = $request->query('filename', 'admin_payment_logs') . '.xlsx';

        $payments = Payment::with(['user', 'cashier'])
            ->whereNotNull('paid_at')
            ->orderByDesc('paid_at')
            ->get();

        return Excel::download(new PaymentsExport($payments), $fileName);
    }
}

