<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentReport;
use Illuminate\Http\Request;
use App\Notifications\ReportResponded;
use Illuminate\Support\Facades\Notification;

class StudentReportController extends Controller
{
    public function index()
    {
        $reports = StudentReport::with('student.occupantProfile', 'student.reservations.room.dormitory')->latest()->get();
        return view('admin.reports.index', compact('reports'));
    }

    public function show(StudentReport $report)
    {
        $report->load('student');
        return view('admin.reports.show', compact('report'));
    }

    public function update(Request $request, StudentReport $report)
    {
        $request->validate([
            'status' => 'required|in:Pending,In Progress,Resolved',
            'admin_response' => 'required|string|max:5000',
        ]);

        $report->update([
            'status' => $request->status,
            'admin_response' => $request->admin_response,
        ]);

        $report->student->notify(new ReportResponded($report));

        return redirect()->route('admin.reports.index')->with('success', 'Response sent and student notified.');
    }

    public function destroy(StudentReport $report)
    {
        $report->delete();
        return redirect()->route('admin.reports.index')->with('success', 'Report deleted successfully.');
    }

}
