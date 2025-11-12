<?php

namespace App\Events;

use App\Models\Otp;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OtpRegister
{
    use Dispatchable, SerializesModels;

     /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(
        public Authenticatable $user,
        public string $code,
        public Otp $otp

    ) {
    }

}
