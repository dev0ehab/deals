<?php

namespace Modules\Accounts\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Accounts\Entities\ResetPasswordCode;


class ResetPasswordCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var ResetPasswordCode
     */
    public ResetPasswordCode $resetPasswordCode;
    public string $username_type;

    /**
     * Create a new event instance.
     *
     * @param ResetPasswordCode $resetPasswordCode
     */
    public function __construct(ResetPasswordCode $resetPasswordCode , string $username_type)
    {
        $this->resetPasswordCode = $resetPasswordCode;
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
