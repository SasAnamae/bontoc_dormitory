<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OccupantProfile;
use Illuminate\Support\Facades\Auth;
use App\Notifications\StudentFinalizedFormsNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class OccupantProfileController extends Controller
{
    public function create()
    {
        return view('student.profile.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'course' => 'required|string|max:255',
            'year_section' => 'required|string|max:255',
            'home_address' => 'required|string',
            'cellphone' => 'required|string',
            'email' => 'required|email',
            'birthday' => 'required|date',
            'age' => 'required|integer',
            'religion' => 'required|string',
            'scholarship' => 'nullable|string',
            'blood_type' => 'nullable|string',
            'allergies' => 'nullable|string',
            'father_fullname' => 'nullable|string',
            'father_phone' => 'nullable|string',
            'mother_fullname' => 'nullable|string',
            'mother_phone' => 'nullable|string',
            'total_monthly' => 'nullable|numeric',
            'electrical_appliances' => 'nullable|array',
            'other_appliance' => 'nullable|string',
        ]);

        // Combine selected appliances and other_appliance
       $appliances = $request->electrical_appliances ?? [];
            if (in_array('Others', $appliances) && $request->filled('other_appliance')) {
                $appliances[] = $request->other_appliance;
                $appliances = array_diff($appliances, ['Others']); // Remove "Others" placeholder
            }


        OccupantProfile::create([
            'user_id' => Auth::id(),
            'course' => $request->course,
            'year_section' => $request->year_section,
            'home_address' => $request->home_address,
            'cellphone' => $request->cellphone,
            'email' => $request->email,
            'birthday' => $request->birthday,
            'age' => $request->age,
            'religion' => $request->religion,
            'scholarship' => $request->scholarship,
            'blood_type' => $request->blood_type,
            'allergies' => $request->allergies,
            'father_fullname' => $request->father_fullname,
            'father_phone' => $request->father_phone,
            'mother_fullname' => $request->mother_fullname,
            'mother_phone' => $request->mother_phone,
            'electrical_appliances' => !empty($appliances) ? implode(',', $appliances) : null,
            'total_monthly' => $request->total_monthly,
        ]);
            
        
        $admins = User::where('role','admin')->get();

          Notification::send($admins, 
        new StudentFinalizedFormsNotification(auth()->user()));

        return redirect()->route('student.dashboard')
            ->with('success', 'Occupant profile submitted successfully!');
    }
    public function finalize()
    {
        $user = Auth::user();
        $user->profile_finalized = true;
        $user->save();

        return redirect()->route('student.dashboard')
            ->with('success', 'Your forms have been finalized. You cannot make further edits.');
    }
}
