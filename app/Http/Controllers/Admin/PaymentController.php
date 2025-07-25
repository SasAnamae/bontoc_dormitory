<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PaymentSchedule;
use App\Models\Payment;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;


class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = User::with('payments')
            ->where('role', 'student')
            ->where('application_status', 'Approved')
            ->with('occupantProfile')
            ->get();

        $paymentSchedules = PaymentSchedule::orderBy('due_date')->get();

        return view('admin.payments.index', compact('students', 'paymentSchedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = User::where('role', 'student')
            ->where('application_status', 'Approved')
            ->get();

        return view('admin.payments.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'default_rate' => 'required|numeric|min:0',
        'due_date' => 'required|date|after_or_equal:today',
        'student_id' => 'required|exists:users,id',
        'additional_fee' => 'nullable|numeric|min:0',
    ]);

    $schedule = PaymentSchedule::create([
        'name' => $request->name,
        'rate' => $request->default_rate,
        'due_date' => $request->due_date,
    ]);

    $totalDue = $request->default_rate + ($request->additional_fee ?? 0);

    $schedule->students()->attach($request->student_id, [
        'additional_fee' => $request->additional_fee ?: 0,
        'total_due' => $totalDue,
    ]);

    return redirect()->route('admin.payments.index')
        ->with('success', 'Payment schedule created for selected student!');
}


    public function destroy($id)
    {
        $schedule = PaymentSchedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('admin.payments.index')
                         ->with('success', 'Payment schedule deleted successfully!');
    }

    public function logs()
    {
        $payments = Payment::with(['student', 'schedule', 'cashier'])
            ->orderByDesc('paid_at')
            ->paginate(20);

        return view('admin.payments.logs', compact('payments'));
    }

    public function export(Request $request)
    {
        $fileName = $request->query('filename', 'admin_payments_overview') . '.xlsx';
        $payments = Payment::with(['user', 'schedule', 'cashier'])->get();

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\PaymentsExport($payments), $fileName);
    }

    public function exportLogs(Request $request)
    {
        $fileName = $request->query('filename', 'admin_payment_logs') . '.xlsx';
        $payments = Payment::with(['user', 'schedule', 'cashier'])
            ->whereNotNull('paid_at')
            ->orderBy('paid_at', 'desc')
            ->get();

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\PaymentsExport($payments), $fileName);
    }
}
