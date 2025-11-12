<?php

namespace Modules\Orders\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\Channel;

class DashboardNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    public $userId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->userId = $data['recipient_id'];
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */

    public function broadcastOn()
    {
        return [
            new Channel('notification-channel.' . $this->userId),
        ];
    }


    public function broadcastWith()
    {
        return $this->data;
    }


    public function broadcastAs()
    {
        return 'notification-event';
    }
}
