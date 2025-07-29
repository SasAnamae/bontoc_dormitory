<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\User;
use App\Notifications\NewAnnouncementNotification;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('users')->latest()->get();
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        $students = User::where('role', 'student')->get();
        return view('admin.announcements.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'message' => 'required|string',
            'audience' => 'required|in:all_students,selected_students,cashier',
            'students' => 'array|nullable'
        ]);

        $announcement = Announcement::create([
            'title' => $request->title,
            'message' => $request->message,
            'audience' => $request->audience,
        ]);

        $recipients = collect();

        if ($request->audience === 'all_students') {
            $recipients = User::where('role', 'student')->get();
            $announcement->users()->attach($recipients->pluck('id'));
        } elseif ($request->audience === 'selected_students' && $request->filled('students')) {
            $recipients = User::whereIn('id', $request->students)->get();
            $announcement->users()->attach($recipients->pluck('id'));
        } elseif ($request->audience === 'cashier') {
            $cashier = User::where('role', 'cashier')->first();
            if ($cashier) {
                $recipients->push($cashier);
                $announcement->users()->attach($cashier->id);
            }
        }

        // Send notifications
        foreach ($recipients as $user) {
            $user->notify(new NewAnnouncementNotification($announcement));
        }

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement successfully sent.');
    }

    public function show(Announcement $announcement)
    {
        $announcement->load('users');
        return view('admin.announcements.show', compact('announcement'));
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->users()->detach();
        $announcement->delete();

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement deleted.');
    }
 }
