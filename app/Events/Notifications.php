<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\Notification;
use Illuminate\Queue\SerializesModels;

class Notifications implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $data;
    public $user;
    public $message;
    public $notificationID;
    public function __construct($message, $user, $data=null )
    {
        $this->user = $user;
        if ($data === null) {
            $this->data = $message;
        } else{
            $this->data = $this->message;
            foreach ($data as $key => $value) {
                $this->data = str_replace("{{" . $key . "}}", $value, $this->data);
            }
        }
        $notification = Notification::create([
            'user_id' => $this->user,
            'message' => $this->data,
            'is_read' => false,
        ]);
        $this->notificationID = $notification->id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new PrivateChannel('notifications.' . $this->user);
    }
    public function broadcastAs(){
        return 'notifications';
    }
    public function broadcastWith(){
        return[
            'id' => $this->notificationID,
            'message' => $this->data,
            'user_id' => $this->user,
        ];
    }
}
