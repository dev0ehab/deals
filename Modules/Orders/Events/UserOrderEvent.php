<?php

namespace Modules\Orders\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Modules\Orders\Transformers\OrderResource;

class UserOrderEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels ;

    public $order;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */

    public function broadcastOn()
    {
        return [
            new PrivateChannel('user-channel.' . $this->order->user_id)
        ];
    }


    public function broadcastWith()
    {
        return [
            // 'message' => trans('orders::orderNotifications.pending.driver.subject', ['id' => $this->order->id]),
            'order' => new OrderResource($this->order)
        ];
    }


    public function broadcastAs()
    {
        return 'user-order-event';
    }
}
