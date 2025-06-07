<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Room;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MessageController extends Controller
{
    public function room($id)
    {
        $room = Room::with('users:id,name,email,role')->findOrFail($id);

        if (!$room->users->contains(auth()->id())) {
            abort(403, 'You are not part of this chat room.');
        }
        $authUser = auth()->user()->only(['id', 'name', 'email', 'role', 'image']);

        $rooms = Room::whereHas('users', function ($query) {
            $query->where('user_id', auth()->id());
        })->select('id', 'title')->get();

        return Inertia::render('chat/Chat', [
            'room' => $room,
            'rooms' => $rooms,
            'auth' => [
                'user' => $authUser,
            ],
        ]);
    }

    public function messages(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
        ]);

        $user = Auth::user();
        $roomId = $request->input('room_id');

        if (!$user->rooms()->where('rooms.id', $roomId)->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $messages = Message::with('user')
            ->where('room_id', $roomId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'messages' => $messages,
        ]);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'text' => 'required|string',
        ]);

        $user = Auth::user();
        $roomId = $request->input('room_id');
        $text = $request->input('text');

        if (!$user->rooms()->where('rooms.id', $roomId)->exists()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message = Message::create([
            'room_id' => $roomId,
            'user_id' => $user->id,
            'text' => $text,
        ]);

        $message->load('user');

        event(new MessageSent($message));


        return response()->json([
            'message' => $message,
        ]);
    }

    public function userRooms()
    {
        $user = Auth::user();
        $rooms = $user->rooms()->select('rooms.id', 'rooms.title')->get();

        return response()->json([
            'rooms' => $rooms,
        ]);
    }

    public function roomsPage()
    {
        $user = auth()->user();
        $rooms = $user->rooms()->select('rooms.id', 'rooms.title')->get();

        return Inertia::render('chat/ChatRoomsPage', [
            'rooms' => $rooms,
            'auth' => [
                'user' => $user->only(['id', 'name', 'email', 'role', 'image']),
            ],
        ]);
    }
}
