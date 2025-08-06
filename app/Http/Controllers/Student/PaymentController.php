<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends Controller
{
    public function index()
    {
        // Get all payments of the currently authenticated student
        $payments = Payment::with(['cashier'])
            ->where('user_id', auth()->id())
            ->latest('paid_at')
            ->paginate(20); // paginate for performance

        return view('student.payments.index', compact('payments'));
    }

    public function download(Request $request)
    {
        $user = auth()->user();

        $payments = Payment::with(['cashier'])
            ->where('user_id', $user->id)
            ->latest('paid_at')
            ->get();

        $filename = $request->input('filename', 'my_payments');

        return Excel::download(new PaymentsExport($payments), $filename . '.xlsx');
    }
}

