<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OccupantProfile;
use App\Notifications\ApplicationApprovalNotification;
use App\Notifications\ReservationStatusNotification;
use App\Models\ApplicationForm;
use App\Models\Reservation;
use App\Models\DormitoryAgreement;

use Illuminate\Http\Request;

class ApplicationController extends Controller
{
   public function index()
    {
        $students = User::where(function ($query) {
            $query->where('application_status', 'Approved')
                ->orWhereHas('occupantProfile')
                ->orWhereHas('dormitoryAgreement');
        })
        ->with('applicationForm', 'occupantProfile', 'dormitoryAgreement')
        ->get();

        return view('admin.applications.index', compact('students'));
    }


    public function approve($id)
    {
        $student = User::findOrFail($id);
        $student->application_status = 'Approved'; // this is OK, it's a string
        $student->save();

        // ✅ Use integer for admin_approved
        if ($student->applicationForm) {
            $student->applicationForm->admin_approved = 1; // 1 = Approved
            $student->applicationForm->save();
        }

        $student->notify(new ApplicationApprovalNotification('Approved'));

        return back()->with('success', 'Application approved successfully.');
    }

    public function reject($id)
    {
        $student = User::findOrFail($id);
        $student->application_status = 'Rejected';
        $student->save();

        if ($student->applicationForm) {
            $student->applicationForm->admin_approved = 2; // 2 = Rejected
            $student->applicationForm->save();
        }

        $student->notify(new ApplicationApprovalNotification('Rejected'));

        return back()->with('success', 'Application rejected successfully.');
    }



    public function show(User $user)
    {
        $application = $user->applicationForm;

        if (!$application) {
            abort(404, 'Application not found.');
        }
        $profile = $user->occupantProfile;
        $agreement = $user->dormitoryAgreement;

        return view('admin.applications.show', [
            'user' => $user,
            'application' => $application,
            'profile' => $profile,
            'agreement' => $agreement,
        ]);
    }


    public function destroy($id)
    {
        $student = User::findOrFail($id);

        // Delete related forms
        if ($student->applicationForm) {
            $student->applicationForm->delete();
        }

        if ($student->occupantProfile) {
            $student->occupantProfile->delete();
        }

        if ($student->dormitoryAgreement) {
            $student->dormitoryAgreement->delete();
        }

         $application = ApplicationForm::where('user_id', $id)->first();
            if ($application) {
                $application->delete();
            }

            // Also delete reservation and update bed availability
            $reservation = Reservation::where('user_id', $id)->latest()->first();
            if ($reservation) {
                app(\App\Http\Controllers\Admin\ReservationController::class)->destroy($reservation->id);
            }


        $student->application_status = null;
        $student->student_forms = false;
        $student->save();

        return redirect()->route('admin.applications.index')
            ->with('success', 'Application deleted successfully. Student can now submit forms again.');
    }

}
