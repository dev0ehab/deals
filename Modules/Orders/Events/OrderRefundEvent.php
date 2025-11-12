<?php

namespace Modules\Orders\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Orders\Entities\Order;

class OrderRefundEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels , Queueable;

    /**
     * @var Order
     */
    public Order $order;

    /**
     * Create a new event instance.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

}
