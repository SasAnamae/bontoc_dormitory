<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DormitoryAgreement;
use Illuminate\Support\Facades\Auth;

class DormitoryAgreementController extends Controller
{
    public function create()
    {
        return view('student.agreement.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'agreement_text' => 'required|string',
            'student_name' => 'required|string',
            'course_year' => 'required|string',
            'date_signed' => 'required|date',
        ]);

        DormitoryAgreement::create([
            'user_id' => Auth::id(),
            'agreement_text' => $request->agreement_text,
            'student_name' => $request->student_name,
            'course_year' => $request->course_year,
            'date_signed' => $request->date_signed,
        ]);

        return redirect()->route('student.forms.summary')
            ->with('success', 'Dormitory Agreement saved successfully!');
    }

    public function edit(DormitoryAgreement $agreement)
    {
        return view('student.agreement.edit', compact('agreement'));
    }

    public function update(Request $request, DormitoryAgreement $agreement)
    {
        $request->validate([
            'agreement_text' => 'required|string',
            'student_name' => 'required|string',
            'course_year' => 'required|string',
            'date_signed' => 'required|date',
        ]);

        $agreement->update([
            'agreement_text' => $request->agreement_text,
            'student_name' => $request->student_name,
            'course_year' => $request->course_year,
            'date_signed' => $request->date_signed,
        ]);

        return redirect()->route('student.forms.summary')
            ->with('success', 'Dormitory Agreement updated successfully!');
    }
}
