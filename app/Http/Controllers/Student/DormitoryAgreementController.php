<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DormitoryAgreement;
use App\Notifications\StudentFinalizedFormsNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
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
            'student_name' => 'required|string',
            'course' => 'required|string',
            'year_section' => 'required|string',
            'date_signed' => 'required|date',
        ]);

        DormitoryAgreement::create([
            'user_id' => Auth::id(),
            'student_name' => $request->student_name,
            'course' => $request->course,
            'year_section' => $request->year_section,
            'date_signed' => $request->date_signed,
        ]);

        return redirect()->route('student.dashboard')
            ->with('success', 'Dormitory Agreement saved successfully. Please proceed to Cashier for Payment!');
    }

    public function edit(DormitoryAgreement $agreement)
    {
        return view('student.agreement.edit', compact('agreement'));
    }

    public function update(Request $request, DormitoryAgreement $agreement)
    {
        $request->validate([
            'student_name' => 'required|string',
            'course' => 'required|string',
            'year_section' => 'required|string',
            'date_signed' => 'required|date',
        ]);

        $agreement->update([
            'student_name' => $request->student_name,
            'course' => $request->course,
            'year_section' => $request->year_section,
            'date_signed' => $request->date_signed,
        ]);

        return redirect()->route('student.forms.summary')
            ->with('success', 'Dormitory Agreement updated successfully!');
    }
}
