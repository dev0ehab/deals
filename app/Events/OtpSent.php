<?php

namespace App\Events;

use App\Models\Otp;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class OtpSent
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
