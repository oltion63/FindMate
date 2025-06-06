<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message->load('user');
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.room.' . $this->message->room_id);
    }
    public function broadcastWith()
    {
        return [
            'id' => $this->message->id,
            'room_id' => $this->message->room_id,
            'user' => [
                'id' => $this->message->user->id,
                'name' => $this->message->user->name,
                'image' => $this->message->user->image,
            ],
            'text' => $this->message->text,
            'created_at' => $this->message->created_at->toDateTimeString(),
        ];
    }
}
