<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['user', 'schedule', 'cashier'])->latest();

        if ($request->filled('name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->filled('or_number')) {
            $query->where('or_number', $request->or_number);
        }

        $payments = $query->paginate(10)->withQueryString();

        return view('cashier.payments.index', compact('payments'));
    }


    public function create()
    {
        $students = \App\Models\User::where('role', 'student')
            ->where('application_status', 'Approved')
            ->with(['schedules' => function($query) {
                $query->orderBy('due_date');
            }])
            ->get();

        return view('cashier.payments.create', compact('students'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'schedule_id' => 'required|exists:payment_schedules,id',
            'amount' => 'required|numeric|min:1',
            'or_number' => 'required|unique:payments,or_number',
            'remarks' => 'nullable|string',
        ]);

        Payment::create([
            'user_id' => $request->user_id,
            'schedule_id' => $request->schedule_id,
            'amount' => $request->amount,
            'or_number' => $request->or_number,
            'remarks' => $request->remarks,
            'status' => 'Confirmed',
            'paid_at' => now(),
            'cashier_id' => auth()->id(),
        ]);

        return redirect()->route('cashier.payments.index')->with('success', 'Payment recorded successfully.');
    }


    public function edit(Payment $payment)
    {
        $students = User::where('role', 'student')
                        ->where('application_status', 'Approved')
                        ->get();

        $schedules = \App\Models\PaymentSchedule::orderBy('due_date')->get();

        return view('cashier.payments.edit', compact('payment', 'students', 'schedules'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'schedule_id' => 'required|exists:payment_schedules,id',
            'amount' => 'required|numeric|min:0',
            'or_number' => 'required|unique:payments,or_number,' . $payment->id,
            'remarks' => 'nullable|string',
        ]);

        $payment->update([
            'user_id' => $request->user_id,
            'schedule_id' => $request->schedule_id,
            'amount' => $request->amount,
            'or_number' => $request->or_number,
            'remarks' => $request->remarks,
        ]);

        return redirect()->route('cashier.payments.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('cashier.payments.index')->with('success', 'Payment deleted successfully.');
    }

  
   public function download(Request $request)
    {
        $query = Payment::with(['user', 'schedule', 'cashier'])->latest();

        if ($request->filled('name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->filled('or_number')) {
            $query->where('or_number', $request->or_number);
        }

        $payments = $query->get();

        if ($payments->isEmpty()) {
            return back()->with('error', 'No matching records found to export.');
        }

        $filename = $request->get('filename', 'filtered_payments');

        return Excel::download(new PaymentsExport($payments), $filename . '.xlsx');
    }
}
