<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dormitory;
use Illuminate\Support\Facades\Storage;

class DormitoryController extends Controller
{
    public function index()
    {
        $dormitories = Dormitory::all();
        return view('admin.dormitories.index', compact('dormitories'));
    }

    public function create()
    {
        return view('admin.dormitories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:dormitories,name',
            'photo' => 'nullable|image|max:2048',
        ]);

         $photoBase64 = null;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $photoBase64 = base64_encode(file_get_contents($file));
        }

        Dormitory::create([
            'name' => $request->name,
            'photo' => $photoBase64,
        ]);

        return redirect()->route('admin.dormitories.index')->with('success', 'Dormitory created successfully!');
    }

    public function edit(Dormitory $dormitory)
    {
        return view('admin.dormitories.edit', compact('dormitory'));
    }

    public function update(Request $request, Dormitory $dormitory)
    {
        $request->validate([
            'name' => 'required|string|unique:dormitories,name,' . $dormitory->id,
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $dormitory->photo = base64_encode(file_get_contents($file));
        }

        $dormitory->name = $request->name;
        $dormitory->save();

        return redirect()->route('admin.dormitories.index')->with('success', 'Dormitory updated successfully!');
    }

    public function destroy(Dormitory $dormitory)
    {
        if ($dormitory->photo) {
            Storage::delete('public/' . $dormitory->photo);
        }
        $dormitory->delete();

        return redirect()->route('admin.dormitories.index')->with('success', 'Dormitory deleted successfully!');
    }
}
