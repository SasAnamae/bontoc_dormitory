<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicationForm;

class ApplicationFormController extends Controller
{
    public function show()
    {
        $student = Auth::user();
        $application = ApplicationForm::where('user_id', $student->id)->first();

        return view('student.application.form', compact('student', 'application'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'school_year' => 'required|string|max:20',
            'full_name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'year_section' => 'required|string|max:255',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_address' => 'required|string|max:255',
            'emergency_contact_number' => 'required|string|max:20',
            'present_status' => 'required|in:new_student,old_new,returnee',
        ]);

        $validated['user_id'] = Auth::id();

        ApplicationForm::updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );

        return redirect()->route('student.dashboard')->with('success', 'Application submitted successfully. Please proceed to the cashier for payment.');
    }

    public function view()
    {
        $student = Auth::user();
        $application = ApplicationForm::where('user_id', $student->id)->firstOrFail();

        return view('student.application.show', compact('student', 'application'));
    }
}
