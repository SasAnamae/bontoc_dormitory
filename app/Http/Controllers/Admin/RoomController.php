<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Dormitory;
use App\Models\Bed;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('dormitory', 'beds')->get();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        $dormitories = Dormitory::all();
        return view('admin.rooms.create', compact('dormitories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dormitory_id' => 'required|exists:dormitories,id',
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'total_beds' => 'required|integer|min:1',
            'bed_type' => 'required|in:Single,Double Deck',
            'num_decks' => 'nullable|integer|min:1|required_if:bed_type,Double Deck',
        ]);

        // Convert photo to base64
        $photoBase64 = null;
        if ($request->hasFile('photo')) {
            $photoBase64 = base64_encode(file_get_contents($request->file('photo')));
        }

        // Create Room
        $room = Room::create([
            'dormitory_id' => $request->dormitory_id,
            'name'         => $request->name,
            'photo'        => $photoBase64,
            'total_beds'   => $request->total_beds,
            'bed_type'     => $request->bed_type,
            'num_decks'    => $request->bed_type === 'Double Deck' ? $request->num_decks : 0,
            'occupied_beds'=> 0,
            'available_beds'=> $request->total_beds,
        ]);

        // Create Beds
        if ($room->bed_type === 'Double Deck' && $room->num_decks > 0) {
            for ($deck = 1; $deck <= $room->num_decks; $deck++) {
                $room->beds()->create([
                    'deck' => "Deck $deck",
                    'position' => 'Upper',
                ]);
                $room->beds()->create([
                    'deck' => "Deck $deck",
                    'position' => 'Lower',
                ]);
            }
        } else {
            for ($i = 1; $i <= $room->total_beds; $i++) {
                $room->beds()->create([
                    'deck' => "Bed $i",
                    'position' => null,
                ]);
            }
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Room and beds added successfully.');
    }

    public function edit(Room $room)
    {
        $dormitories = Dormitory::all();
        return view('admin.rooms.edit', compact('room', 'dormitories'));
    }

   public function update(Request $request, Room $room)
{
    $request->validate([
        'dormitory_id' => 'required|exists:dormitories,id',
        'name' => 'required|string|max:255',
        'photo' => 'nullable|image|max:2048',
        'total_beds' => 'required|integer|min:1',
        'bed_type' => 'required|in:Single,Double Deck',
        'num_decks' => 'nullable|integer|min:1|required_if:bed_type,Double Deck',
    ]);

    // Update photo if uploaded
    if ($request->hasFile('photo')) {
        $room->photo = base64_encode(file_get_contents($request->file('photo')));
    }

    // Update Room fields
    $room->update([
        'dormitory_id'   => $request->dormitory_id,
        'name'           => $request->name,
        'total_beds'     => $request->total_beds,
        'bed_type'       => $request->bed_type,
        'num_decks'      => $request->bed_type === 'Double Deck' ? $request->num_decks : 0,
        'available_beds' => $request->total_beds - $room->occupied_beds,
    ]);

        $room->beds()->delete();

        if ($room->bed_type === 'Double Deck' && $room->num_decks > 0) {
            for ($deck = 1; $deck <= $room->num_decks; $deck++) {
                $room->beds()->create([
                    'deck'     => "Deck $deck",
                    'position' => 'Upper',
                ]);
                $room->beds()->create([
                    'deck'     => "Deck $deck",
                    'position' => 'Lower',
                ]);
            }
        } else {
            for ($i = 1; $i <= $room->total_beds; $i++) {
                $room->beds()->create([
                    'deck'     => "Bed $i",
                    'position' => null,
                ]);
            }
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->beds()->delete(); 
        $room->delete();      
        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully.');
    }
}
