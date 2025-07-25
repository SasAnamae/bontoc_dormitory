<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Dormitory;

class DormitoryController extends Controller
{
    public function show(Dormitory $dorm)
    {
        $dorm->load('rooms.beds');
        return view('student.dorm.show', compact('dorm'));
    }
}

