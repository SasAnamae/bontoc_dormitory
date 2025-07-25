<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\OccupantProfile;
use App\Models\DormitoryAgreement;
use App\Notifications\StudentFinalizedFormsNotification;
use App\Models\User;

class StudentFormsController extends Controller
{
    public function summary()
    {
        $user = Auth::user();
        $profile = $user->occupantProfile;
        $agreement = $user->dormitoryAgreement;

        if (!$profile) {
            return redirect()->route('student.profile.create')
                ->with('error', 'Please complete your Occupant Profile first.');
        }

        if (!$agreement) {
            return redirect()->route('student.agreement.create')
                ->with('error', 'Please complete your Dormitory Agreement form.');
        }

        return view('student.forms.summary', compact('profile', 'agreement'));
    }


   public function finalize()
    {
        $user = Auth::user();
        $user->student_forms = true;
        $user->save();

        // Notify all admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new StudentFinalizedFormsNotification($user));
        }

        return redirect()->route('student.dashboard')
            ->with('success', 'Your forms have been finalized! 🎉 The admin has been notified.');
    }
}
