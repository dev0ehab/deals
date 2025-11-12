<?php

namespace Modules\Accounts\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Accounts\Entities\Verification;


class VerificationCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Verification
     */
    public Verification $verification;
    public $username_type;

    /**
     * Create a new event instance.
     *
     * @param Verification $verification
     */
    public function __construct(Verification $verification , string $username_type)
    {
        $this->verification = $verification;
        $this->username_type = $username_type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

}
