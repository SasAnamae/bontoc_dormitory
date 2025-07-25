<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TermsController extends Controller
{
    public function show()
    {
        return view('student.terms');
    }

    public function agree(Request $request)
    {
        $user = Auth::user();
        $user->agreed_to_terms = true;
        $user->save();

        return redirect()->route('student.dashboard')->with('success', 'Thank you for agreeing to the Terms & Conditions!');
    }
}


