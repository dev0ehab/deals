<?php

namespace Modules\Orders\Listeners;

use App\Services\NotificationsService;
use App\Services\PaymentGateways\MyfatoorahService;
use Modules\Orders\Events\CustomerNewOrderEvent;
use Modules\Orders\Events\OrderRefundEvent;

class OrderRefundListener
{
    private $notificationService;
    private $paymentService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(NotificationsService $notificationService, MyfatoorahService $paymentService)
    {
        $this->notificationService = $notificationService;
        $this->paymentService = $paymentService;
    }

    /**
     * Handle the event.
     *
     * @param CustomerNewOrderEvent $event
     * @return void
     */
    public function handle(OrderRefundEvent $event)
    {
        $order = $event->order;

        $this->paymentService->makeRefund($order->invoice_id, $order->total);
        sleep(3);
        $data = $this->paymentService->getRefundStatus($order->invoice_id);

        $refunded = "false";
        if ($data && $data->Data->RefundStatusResult[0]->RefundStatus == 'Refunded') {
            $order->is_refunded = true;
            $order->save();
            $refunded = "true";
        }

        $subject = ["orders::orderNotifications.refund.user.{$refunded}.subject", ['id' => $order->id]];
        $body = ["orders::orderNotifications.refund.user.{$refunded}.body"];
        $this->notificationService->handleNotification('refunded', $order->user, $subject, $body, $order);
    }
}
