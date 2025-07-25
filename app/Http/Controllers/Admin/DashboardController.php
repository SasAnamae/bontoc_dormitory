<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dormitory;
use App\Models\Room;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Payment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $monthlyPayments = Payment::whereMonth('paid_at', Carbon::now()->month)
            ->whereYear('paid_at', Carbon::now()->year)
            ->sum('amount');

        return view('admin.dashboard', [
            'dormitoriesCount' => Dormitory::count(),
            'roomsCount' => Room::count(),
            'studentsCount' => User::where('role', 'student')->count(),
            'reservationsCount' => Reservation::where('status', 'pending')->count(),
            'paymentsCount' => Payment::count(),
            'monthlyPayments' => $monthlyPayments,
        ]);
    }
}

