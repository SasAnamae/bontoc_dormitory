<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckTermsAgreement
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'student') {
            if (!Auth::user()->agreed_to_terms &&
                !$request->is('student/terms') &&
                !$request->is('student/terms/agree') &&
                !$request->is('logout')) {
                return redirect()->route('student.terms');
            }
        }
        return $next($request);
    }
}

