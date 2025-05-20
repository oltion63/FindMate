<?php

namespace App\Http\Controllers;

use App\Events\Notifications;
use App\Models\Notification;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NotificationsController extends Controller
{
    public function index(){
        $user_id = auth()->id();
        $notifications = Notification::where('user_id', $user_id)->get();
        return Inertia::render('components/AppSidebarHeader', [
            'notifications' => $notifications
        ]);
    }
}
