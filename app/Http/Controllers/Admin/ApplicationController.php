<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ApplicationApprovalNotification;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        // Fetch all students with forms submitted
        $students = User::whereHas('occupantProfile')
                        ->whereHas('dormitoryAgreement')
                        ->with('occupantProfile', 'dormitoryAgreement')
                        ->get();

        return view('admin.applications.index', compact('students'));
    }

    public function approve($id)
    {
        $student = User::findOrFail($id);
        $student->application_status = 'Approved';
        $student->save();

        // Notify the student
        $student->notify(new ApplicationApprovalNotification('Approved'));

        return back()->with('success', 'Application approved successfully.');
    }

    public function reject($id)
    {
        $student = User::findOrFail($id);
        $student->application_status = 'Rejected';
        $student->save();

        $student->notify(new ApplicationApprovalNotification('Rejected'));

        return back()->with('success', 'Application rejected successfully.');
    }

    public function show($id)
    {
        $application = User::with(['occupantProfile', 'dormitoryAgreement'])->findOrFail($id);

        return view('admin.applications.show', compact('application'));
    }
   public function destroy($id)
    {
        $student = User::findOrFail($id);

        if ($student->occupantProfile) {
            $student->occupantProfile->delete();
        }

        if ($student->dormitoryAgreement) {
            $student->dormitoryAgreement->delete();
        }

        $student->application_status = null;
        $student->student_forms = false;
        $student->save();

        return redirect()->route('admin.applications.index')
            ->with('success', 'Application deleted successfully. Student can now submit forms again.');
    }

}
