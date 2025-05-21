<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NotificationsController extends Controller
{
    public function index(){
        $user_id = auth()->id();
        $notifications = Notification::where('user_id', $user_id)->where('is_read', 0)->get();
        return Inertia::render('components/AppSidebarHeader', [
            'notifications' => $notifications
        ]);
    }

    public function markAsRead(){
        $notifications = Notification::where('user_id', auth()->id())
            ->where('is_read', 0)
            ->update(['is_read' => 1]);
        return back()->with('success', 'Notifications cleared');
        }

}
