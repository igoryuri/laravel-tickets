<?php

namespace App\Events;

use App\Models\Monitoring;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RefreshPusherEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var Monitoring
     */
    public $monitoring;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Monitoring $monitoring)
    {
        $this->monitoring = $monitoring;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('refresh.monitoring.' . $this->monitoring->ticket_id);
    }
}
