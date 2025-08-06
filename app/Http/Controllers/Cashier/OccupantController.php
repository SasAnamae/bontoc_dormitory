<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PaymentSchedule;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;

class OccupantController extends Controller
{
    public function index()
    {
        $occupants = User::with(['payments', 'reservations.room.dormitory', 'occupantProfile'])
            ->where('role', 'student')
            ->where('application_status', 'Approved')
            ->get();

        return view('cashier.occupants.index', compact('occupants'));
    }

    public function download(Request $request)
    {
        $payments = Payment::with(['user', 'schedule.students', 'cashier'])
            ->latest()
            ->get();

        $filename = $request->get('filename', 'cashier_payments') . '.xlsx';

        return Excel::download(new PaymentsExport($payments), $filename);
    }

    public function export()
    {
        $payments = Payment::with(['user', 'schedule.students', 'cashier'])
            ->latest()
            ->get();

        return Excel::download(new PaymentsExport($payments), 'occupants_payments.xlsx');
    }

}

