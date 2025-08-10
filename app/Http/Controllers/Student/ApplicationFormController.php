<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ApplicationForm;
use Carbon\Carbon;

class ApplicationFormController extends Controller
{
    public function show()
    {
        $student = Auth::user();
        $application = ApplicationForm::where('user_id', $student->id)->first();

        $currentYear = Carbon::now()->year;
        $schoolYears = [];
        for ($i = 0; $i < 6; $i++) {
            $start = Carbon::create($currentYear + $i, 6, 1); 
            $schoolYears[] = $start;
        }

        return view('student.application.form', compact('student', 'application', 'schoolYears'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'school_year' => 'required|date',
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

        return redirect()->route('student.agreement.create')->with('success', 'Application submitted successfully. Please read the terms and conditions carefully.');
    }

    public function view()
    {
        $student = Auth::user();
        $application = ApplicationForm::where('user_id', $student->id)->firstOrFail();
        return view('student.application.show', compact('student', 'application'));
    }
}
