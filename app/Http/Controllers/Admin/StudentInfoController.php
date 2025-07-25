<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StudentInfoController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'student')
            ->where('student_forms', true)
            ->with([
                'occupantProfile', 
                'reservations.room.dormitory'
            ])
            ->get();

        return view('admin.student_info.index', compact('students'));
    }
}
