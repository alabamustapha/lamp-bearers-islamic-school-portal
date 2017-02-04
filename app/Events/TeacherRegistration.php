<?php

namespace App\Events;

use App\User;
use App\Teacher;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TeacherRegistration
{
    use InteractsWithSockets, SerializesModels;

    public  $user;
    public $teacher;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Teacher $teacher, User $user)
    {
        $this->teacher = $teacher;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
