<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\PaymentSchedule;
use Illuminate\Support\Facades\Auth;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends Controller
{
   public function index()
{
    $schedules = PaymentSchedule::whereHas('students', function ($q) {
        $q->where('users.id', auth()->id());
    })
    ->with([
        'students' => function ($q) {
            $q->where('users.id', auth()->id());
        },
        'payments' => function ($q) {
            $q->where('user_id', auth()->id());
        }
    ])
    ->orderBy('due_date', 'desc')
    ->get();

    $student = auth()->user()->load(['payments.schedule.students']);

    return view('student.payments.index', compact('schedules', 'student'));
}





    public function download(Request $request)
    {
        $user = auth()->user();

        $payments = Payment::with(['schedule', 'cashier'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $filename = $request->input('filename', 'my_payments');

        return Excel::download(new PaymentsExport($payments), $filename . '.xlsx');
    }
}

