<?php

namespace App\Providers;

use App\Events\OtpRegister;
use App\Events\OtpSent;
use App\Listeners\OtpSentListener;
use App\Listeners\SendSmsListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\sendEmailVerificationNotifications;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Accounts\Events\ResetPasswordCreated;
use Modules\Accounts\Events\VerificationCreated;
use Modules\Accounts\Listeners\SendResetPasswordCode;
use Modules\Accounts\Listeners\SendVerificationCode;
use Modules\Deliveries\Events\DeliveryStatusEvent;
use Modules\Deliveries\Listeners\DeliveryStatusListener;
use Modules\Orders\Events\DeliveryFeeEvent;
use Modules\Orders\Events\OrderRefundEvent;
use Modules\Orders\Events\UpdateOrderStatusEvent;
use Modules\Orders\Listeners\DeliveryFeeListener;
use Modules\Orders\Listeners\OrderRefundListener;
use Modules\Orders\Listeners\UpdateOrderStatusListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            sendEmailVerificationNotifications::class,
        ],

        VerificationCreated::class => [
            SendVerificationCode::class,
        ],

        ResetPasswordCreated::class => [
            SendResetPasswordCode::class,
        ],
        OtpSent::class => [
            OtpSentListener::class
        ],
        OtpRegister::class => [
            SendSmsListener::class
        ],

        DeliveryStatusEvent::class => [
            DeliveryStatusListener::class
        ],

        UpdateOrderStatusEvent::class => [
            UpdateOrderStatusListener::class
        ],

        OrderRefundEvent::class => [
            OrderRefundListener::class
        ],

        DeliveryFeeEvent::class => [
            DeliveryFeeListener::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
