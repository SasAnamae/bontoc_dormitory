<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function show(User $user)
    {
        $application = $user->applicationForm;

        if (!$application) {
            return redirect()->back()->with('error', 'No submitted application found for this student.');
        }

        return view('cashier.application.show', compact('user', 'application'));
    }
}


