<?php

namespace App\Events;

use App\Notifications\UserCreated;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user, $password,$email;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $password,$email)
    {
        $this->user = $user;
        $this->password = $password;
        $this->email = $email;
        $user->notify(new UserCreated($password,$email));
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
