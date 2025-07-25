<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Room;

class RoomController extends Controller
{
    public function show(Room $room)
    {
        $room->load('beds');
        return view('student.room.show', compact('room'));
    }
}

