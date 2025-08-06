<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Dormitory;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $hasReservation = $user->reservations()->exists();
        $hasApplication = $user->applicationForm()->exists();
        $hasPayment = $user->payments()->exists();
        $applicationForm = $user->applicationForm;
        $adminApproved = $applicationForm && $applicationForm->admin_approved;

        $hasProfileAndAgreement = $user->occupantProfile && $user->dormitoryAgreement;

        $steps = [
            ['label' => 'Reservation', 'complete' => $hasReservation],
            ['label' => 'Application', 'complete' => $hasApplication],
            ['label' => 'Payment', 'complete' => $hasPayment],
            ['label' => 'Admin Approval', 'complete' => $adminApproved],
            ['label' => 'Profile & Agreement', 'complete' => $hasProfileAndAgreement],
        ];

        $dormitories = Dormitory::all();

        return view('student.dashboard', compact('dormitories', 'steps'));
    }
}
