<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        // Get the currently authenticated user
        $user = auth()->user();

        // Retrieve the user's notifications
        $notifications = $user->notifications;

        // Mark notifications as read (if desired)
        // $user->unreadNotifications->markAsRead();

        // Render a view to display notifications
        return view('frontend.pages.allFeedBack', compact('notifications'));
    }

    public function markAsRead($notificationId)
    {
        // Find the notification by ID
        $auth = auth()->user();
        $notification = $auth->notifications()->find($notificationId);

        // Mark the notification as read
        if ($notification) {
            $notification->markAsRead();
        }

        // Redirect back to the notifications page or any other desired route
        return back()->with('success', 'Notification marked as read.');
    }

    public function unreadNotifications()
    {
        $user = auth()->user();

        // Fetch unread notifications
        $notifications = $user->unreadNotifications;

        return response()->json(['notifications' => $notifications]);
    }
}
