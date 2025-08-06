<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use App\Models\ApplicationForm;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Notifications\ApplicationSubmittedNotification;


class PaymentController extends Controller
{
    // Show paginated list of payments
    public function index(Request $request)
    {
        $query = Payment::with(['user', 'cashier'])->latest();

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

    // Show the form for creating a new payment
    public function create()
    {
        // Only fetch students who submitted the application
        $students = User::where('role', 'student')
            ->whereIn('id', function ($query) {
                $query->select('user_id')->from('application_forms');
            })
            ->get();

        return view('cashier.payments.create', compact('students'));
    }

    // Store new payment
    public function store(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'amount'     => 'required|numeric|min:1',
            'or_number'  => 'required|unique:payments,or_number',
            'remarks'    => 'nullable|string',
            'paid_at'    => 'required|date',
        ]);

        Payment::create([
            'user_id'    => $request->user_id,
            'amount'     => $request->amount,
            'or_number'  => $request->or_number,
            'remarks'    => $request->remarks,
            'status'     => 'Confirmed',
            'paid_at'    => $request->paid_at,
            'cashier_id' => auth()->id(),
        ]);

         // ✅ Mark application as cashier approved
        ApplicationForm::where('user_id', $request->user_id)
            ->update(['cashier_approved' => true]);

        // ✅ Notify all admins
        $admins = User::where('role', 'admin')->get();
        $student = User::find($request->user_id);

        foreach ($admins as $admin) {
            $admin->notify(new ApplicationSubmittedNotification($student));
        }

        // ✅ Mark the application as cashier-approved (but not fully approved by admin yet)
        ApplicationForm::where('user_id', $request->user_id)->update([
            'cashier_approved' => true
        ]);

        return redirect()->route('cashier.payments.index')->with('success', 'Payment recorded and application marked as cashier-approved.');
    }

    // Show the form for editing a payment
    public function edit(Payment $payment)
    {
        $students = User::where('role', 'student')
            ->whereIn('id', function ($query) {
                $query->select('user_id')->from('application_forms');
            })
            ->get();

        return view('cashier.payments.edit', compact('payment', 'students'));
    }

    // Update existing payment
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'amount'     => 'required|numeric|min:0',
            'or_number'  => 'required|unique:payments,or_number,' . $payment->id,
            'remarks'    => 'nullable|string',
            'paid_at'    => 'required|date',
        ]);

        $payment->update([
            'user_id'    => $request->user_id,
            'amount'     => $request->amount,
            'or_number'  => $request->or_number,
            'remarks'    => $request->remarks,
            'paid_at'    => $request->paid_at,
        ]);

        return redirect()->route('cashier.payments.index')->with('success', 'Payment updated successfully.');
    }

    // Delete a payment
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return redirect()->route('cashier.payments.index')->with('success', 'Payment deleted successfully.');
    }

    // Download filtered payment records as Excel
    public function download(Request $request)
    {
        $query = Payment::with(['user', 'cashier'])->latest();

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

