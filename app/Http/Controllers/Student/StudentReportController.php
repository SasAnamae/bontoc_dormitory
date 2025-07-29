<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentReport;
use App\Models\User;
use App\Notifications\NewStudentReportNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class StudentReportController extends Controller
{
    public function index()
    {
        $reports = StudentReport::where('student_id', auth()->id())->latest()->get();
        return view('student.report.index', compact('reports'));
    }

    public function create()
    {
        return view('student.report.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'message' => 'required|string',
        ]);

        $report = StudentReport::create([
            'student_id' => auth()->id(),
            'title' => $request->title,
            'message' => $request->message,
            'status' => 'Pending',
        ]);

        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new NewStudentReportNotification($report));

        return redirect()->route('student.report.index')->with('success', 'Report submitted successfully.');
    }

    public function destroy(StudentReport $report)
    {
        if ($report->student_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $report->delete();

        return redirect()->route('student.report.index')->with('success', 'Report deleted successfully.');
    }

    public function show(StudentReport $report)
    {
        if ($report->student_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('student.report.show', compact('report'));
    }
}

