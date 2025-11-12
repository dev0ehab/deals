<?php

namespace Modules\Orders\Listeners;

use App\Enums\NotificationTypesEnum;
use App\Services\NotificationsService;
use Modules\Accounts\Entities\Admin;
use Modules\Orders\Events\CustomerNewOrderEvent;

class CustomerNewOrderListener
{

    private $service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(NotificationsService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the event.
     *
     * @param CustomerNewOrderEvent $event
     * @return void
     */
    public function handle(CustomerNewOrderEvent $event)
    {
        $admins = Admin::whereRole(['super_admin'])->get();
        $admin_subject = ["orders::orderNotifications.pending.vendor.subject", ['id' => $event->order->id]];
        $admin_body = ["orders::orderNotifications.pending.vendor.body", ['id' => $event->order->id]];

        foreach ($admins as $admin) {
            $this->service->handleNotification(NotificationTypesEnum::NewOrder->value, $admin, $admin_subject, $admin_body, $event->order);
        }
    }
}
