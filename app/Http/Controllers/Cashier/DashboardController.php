<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Default to current month/year
        $month = $request->month ?? now()->month;
        $year = $request->year ?? now()->year;

        // Total registered students (role: student, approved)
        $registeredStudents = User::where('role', 'student')
            ->where('application_status', 'Approved')
            ->count();

        // Students who paid in selected month
        $studentsPaidIds = Payment::whereMonth('paid_at', $month)
            ->whereYear('paid_at', $year)
            ->distinct('user_id')
            ->pluck('user_id')
            ->toArray();

        $studentsPaid = count($studentsPaidIds);
        $studentsNotPaid = $registeredStudents - $studentsPaid;

        // Total payments collected in selected month
        $monthlyTotal = Payment::whereMonth('paid_at', $month)
            ->whereYear('paid_at', $year)
            ->sum('amount');

        return view('cashier.dashboard', [
            'occupantsCount' => User::where('role', 'student')
                ->where('application_status', 'approved')->count(),
            'studentsPaid' => $studentsPaid,
            'studentsNotPaid' => $studentsNotPaid,
            'monthlyTotal' => $monthlyTotal,
            'selectedMonth' => $month,
            'selectedYear' => $year,
        ]);
    }
}