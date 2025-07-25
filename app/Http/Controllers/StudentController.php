<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dormitory;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentController extends Controller
{
    public function dashboard()
    {
        $dormitories = Dormitory::all();
        return view('student.dashboard');
    }

    public function showTerms()
    {
        return view('student.terms');
    }

    public function agreeTerms(Request $request)
    {
        $user = Auth::user();
        $user->agreed_to_terms = true;
        $user->save();

        return redirect()->route('student.dashboard')->with('success', 'Thank you for agreeing to the terms!');
    }
}
