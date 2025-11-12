<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Orders\Entities\Order;

class NewOrder implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var
     */
    public $username;

    /**
     * @var array|Application|Translator|string|null
     */
    public $message;

    /**
     * @var
     */
    public $order;

    /**
     * @var string
     */
    public $route;

    /**
     * @var string
     */
    public $image;

    /**
     * @var string
     */
    public $sound;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($username, Order $order)
    {
        $this->username = $username;
        $this->order = $order;
        $this->message = trans('orders::orderNotifications.new.body', [
            'user' => $username,
        ]);
        $this->image = asset('backend/images/logos/Logo-Symbol@1x.png');
        $this->sound = asset('backend/sound/EveWasel_NewOrder_Notification.mp3');
        $this->route = route('dashboard.orders.show', $order);
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('new-order');
    }
}
