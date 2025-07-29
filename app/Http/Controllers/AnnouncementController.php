<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement; 
use App\Models\User;   
use App\Notifications\NewAnnouncementNotification;
use Illuminate\Support\Facades\Notification;

class AnnouncementController extends Controller
{
   
    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);

        // Mark notification as read
        $user = auth()->user();
        if ($user) {
            $notification = $user->unreadNotifications()
                                ->where('data->announcement_id', $id)
                                ->first();
            if ($notification) {
                $notification->markAsRead();
            }
        }

        return view('audience.show', compact('announcement'));
    }
}
