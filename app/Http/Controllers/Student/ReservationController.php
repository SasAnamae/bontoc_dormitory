<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Bed;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewReservationNotification;

class ReservationController extends Controller
{
   
    public function index()
    {
        $reservations = Reservation::with('bed.room.dormitory')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('student.reservations.index', compact('reservations'));
    }

    public function store($bed_id)
    {
        $bed = Bed::with('room')->findOrFail($bed_id);

        if ($bed->user_id) {
            return back()->with('error', 'This bed is already reserved.');
        }

        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'bed_id' => $bed->id,
            'room_id' => $bed->room->id,
            'status' => 'Pending',
        ]);

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewReservationNotification($reservation));
        }

        return redirect()->route('student.dashboard')->with('success', 'Reservation submitted! Waiting for admin approval.');
    }

    public function destroy($id)
    {
        $reservation = Reservation::where('user_id', Auth::id())->findOrFail($id);
        $reservation->bed->update(['is_occupied' => false]);
        $reservation->delete();

        return back()->with('success', 'Reservation deleted successfully.');
    }
}
