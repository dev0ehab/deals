<?php

namespace Modules\Orders\Listeners;

use App\Enums\OrderStatusEnum;
use App\Services\NotificationsService;
use Modules\Accounts\Entities\Admin;
use Modules\Accounts\Entities\User;
use Modules\Orders\Events\OrderRefundEvent;
use Modules\Orders\Events\UpdateOrderStatusEvent;
use Modules\Orders\Events\UserOrderEvent;

class UpdateOrderStatusListener
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
     * @param UpdateOrderStatusEvent $event
     * @return void
     */
    public function handle(UpdateOrderStatusEvent $event)
    {

        $order = $event->order;
        $status = $order->status;


        // fire the event user order
        UserOrderEvent::dispatch($order);

        if ($status == OrderStatusEnum::PENDING->value) {

            // notify the user that order is PENDING
            $subject = ["orders::orderNotifications.new.user.subject"];
            $body = ["orders::orderNotifications.new.user.body", ['id' => $order->id]];
            $this->service->handleNotification(OrderStatusEnum::PENDING->value, $order->user, $subject, $body, $order);


            $subject = ["orders::orderNotifications.new.admin.subject"];
            $body = ["orders::orderNotifications.new.admin.body", ['id' => $order->id]];

            foreach (Admin::get() as $admin) {
                $this->service->handleNotification(OrderStatusEnum::PENDING->value, $admin, $subject, $body, $order);
            }
        } elseif ($status == OrderStatusEnum::CANCELLED->value) {

            // make the order total refunded to user
            // event(new OrderRefundEvent($order));

            $userClass = get_class(auth()->user());

            // notify the user that order is cancelled
            $types = [
                Admin::class => 'admin',
                User::class  => 'user',
            ];

            $subject = ["orders::orderNotifications.cancelled.subject"];
            $type = trans("orders::orderNotifications.user-types.{$types[$userClass]}");

            if (is_null($order->reason)) {
                $body = ["orders::orderNotifications.cancelled.body", ['id' => $order->id, 'type' => $type]];
            } else {
                $reason = \Lang::has("orders::orderNotifications.cancelled.reasons.{$order->reason}") ?
                    trans("orders::orderNotifications.cancelled.reasons.{$order->reason}", [], $order->user->preferred_locale) :
                    $order->reason;

                $body = ["orders::orderNotifications.cancelled.body_reason", ['id' => $order->id, 'reason' => $reason, 'type' => $type]];
            }

            unset($types[$userClass]);

            foreach ($types as $type) {
                if ($type == 'admin') {
                    $admins = Admin::get();
                    foreach ($admins as $admin) {
                        $this->service->handleNotification(OrderStatusEnum::CANCELLED->value, $admin, $subject, $body, $order);
                    }
                } else {
                    $this->service->handleNotification(OrderStatusEnum::CANCELLED->value, $order->$type, $subject, $body, $order);
                }
            }
        } else {

            // notify the user that order status is changed
            $subject = ["orders::orderNotifications.change-status.subject"];
            $body = ["orders::orderNotifications.change-status.body", ['id' => $order->id , 'status' => $order->status]];
            $this->service->handleNotification($order->status, $order->user, $subject, $body, $order);
        }
    }
}
