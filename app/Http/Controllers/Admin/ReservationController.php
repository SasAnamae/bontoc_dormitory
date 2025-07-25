<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Notifications\ReservationStatusNotification;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('user', 'bed.room.dormitory')->latest()->get();
        return view('admin.reservations.index', compact('reservations'));
    }

    public function updateStatus($id, $status)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->status = $status;
        $reservation->save();

        if ($status === 'Approved') {
            $reservation->bed->update(['is_occupied' => true]);
            $reservation->bed->room->decrement('available_beds');
            $reservation->bed->room->increment('occupied_beds');
        } else {
            $reservation->bed->update(['is_occupied' => false]);
        }

        $reservation->user->notify(new ReservationStatusNotification($reservation));

        return redirect()->back()->with('success', "Reservation {$status} successfully.");
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->status === 'Approved') {
            $reservation->bed->update(['is_occupied' => false]);
            $reservation->bed->room->increment('available_beds');
            $reservation->bed->room->decrement('occupied_beds');
        }

        $reservation->delete();

        return back()->with('success', 'Reservation deleted successfully.');
    }
}
