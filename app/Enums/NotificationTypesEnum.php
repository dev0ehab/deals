<?php

namespace App\Enums;

use Kongulov\Traits\InteractWithEnum;

enum NotificationTypesEnum: string
{
    use InteractWithEnum;

    case General = 'general';

    case ChangeStatus = 'changeStatus';

    case CancelOrder = 'cancelOrder';


    case PREPAID        = "prePaid";
    case PENDING        = "pending";
    case PROCESSING     = "processing";
    case READY          = "ready";
    case TRANSIT        = "transit";
    case DELIVERED      = "delivered";
    case CANCELLED      = "cancelled";
    case REJECTED       = "rejected";
    case REFUNDED       = "refunded";


    public static function NotificationUrl($type, $id)
    {
        return match ($type) {
            self::General->value => '',
            self::ChangeStatus->value => route('dashboard.orders.show', $id),

            "pending"    => route('dashboard.orders.show', $id),
            "processing" => "",
            "ready"      => "",
            "transit"    => "",
            "delivered"  => "",
            "cancelled"  => route('dashboard.orders.show', $id),
            "rejected"   => "",
            "refunded"   => "",
        };
    }
}
