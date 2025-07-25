<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Dormitory;

class DashboardController extends Controller
{
    public function index()
    {
        $dormitories = Dormitory::all();
        return view('student.dashboard', compact('dormitories'));
    }
}
