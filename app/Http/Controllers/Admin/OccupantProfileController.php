<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OccupantProfile;
use Illuminate\Http\Request;
use App\Models\User;

class OccupantProfileController extends Controller
{
    public function edit(OccupantProfile $profile)
    {
        return view('admin.applications.edit', compact('profile'));
    }

    public function update(Request $request, OccupantProfile $profile)
    {
        $request->validate([
            'course_section' => 'required|string|max:255',
            'home_address' => 'required|string',
            'cellphone' => 'required|string',
            'email' => 'required|email',
            'birthday' => 'required|date',
            'age' => 'required|integer',
            'religion' => 'nullable|string',
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

        $appliances = $request->electrical_appliances ?? [];
        if (in_array('Others', $appliances) && $request->filled('other_appliance')) {
            $appliances[] = $request->other_appliance;
            $appliances = array_diff($appliances, ['Others']);
        }

        $profile->update([
            'course_section' => $request->course_section,
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
            'electrical_appliances' => implode(',', $appliances),
            'total_monthly' => $request->total_monthly,
        ]);

        return redirect()->route('admin.applications.index')
            ->with('success', 'Profile updated successfully!');
    }
}
