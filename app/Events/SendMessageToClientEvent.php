<?php

namespace App\Events;


use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class SendMessageToClientEvent implements ShouldBroadcast {
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public string $message;

    public function __construct() {
        $this->message = 'Hello friend';
    }

    public function broadcastOn() { // use PrivateChannel to create channels only for auth users
        return new PrivateChannel('test'); // enter channel name
    }
}
