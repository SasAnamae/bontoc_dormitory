<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
        
    public function destroy($id)
    {
        auth()->user()->notifications()->findOrFail($id)->delete();

        return back()->with('success', 'Notification deleted.');
    }

    public function destroyAll()
    {
        auth()->user()->notifications()->delete();

        return back()->with('success', 'All notifications cleared.');
    }

    public function fetch()
    {
        $user = auth()->user();
        $count = $user->unreadNotifications->count();
        $html = view('layouts.partials.notification-items', ['__data' => get_defined_vars()])->render();

        return response()->json([
            'count' => $count,
            'html' => $html,
        ]);

    }
}
