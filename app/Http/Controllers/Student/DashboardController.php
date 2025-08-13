<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Dormitory;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $hasReservation = $user->reservations()->exists();
        $hasApplication = $user->applicationForm()->exists();

        $applicationForm = $user->applicationForm;
        $adminApproved = $applicationForm && $applicationForm->admin_approved;

        // ✅ Only mark payment complete if it's made AFTER the current application was created
        $hasPayment = false;
        if ($applicationForm) {
            $hasPayment = $user->payments()
                ->where('created_at', '>', $applicationForm->created_at)
                ->exists();
        }

        $hasProfileAndAgreement = $user->occupantProfile && $user->dormitoryAgreement;

        // Progress tracker logic (no skipping)
        $steps = [
            ['label' => 'Reservation', 'complete' => $hasReservation],
            ['label' => 'Application', 'complete' => $hasReservation && $hasApplication],
            ['label' => 'Payment', 'complete' => $hasReservation && $hasApplication && $hasPayment],
            ['label' => 'Admin Approval', 'complete' => $hasReservation && $hasApplication && $adminApproved],
            ['label' => 'Profile & Agreement', 'complete' => $hasProfileAndAgreement],
        ];

        $dormitories = Dormitory::all();

        return view('student.dashboard', compact('dormitories', 'steps'));
    }

    /**
     * Reset student's progress (reservation, application, profile, agreement)
     * Payments are preserved but won't count towards new applications
     */
    public function resetProgress($id)
    {
        $user = User::findOrFail($id);

        // Delete reservation & application
        $user->reservations()->delete();
        $user->applicationForm()->delete();

        // Delete profile and agreement if exist
        $user->occupantProfile()->delete();
        $user->dormitoryAgreement()->delete();

        return back()->with('success', 'Student progress has been reset successfully (payments preserved).');
    }
}

