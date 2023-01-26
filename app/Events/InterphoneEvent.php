<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InterphoneEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    private $userId;
    public $message;
    public $route;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userId,$message,$route)
    {
        $this->userId = $userId;
        $this->message = $message;
        $this->route = $route;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */

     public function broadcastOn()
     {
         return new PrivateChannel("interphone.{$this->userId}");
     }

     public function broadcastAs(){
         return "send.interphone";
     }
}
