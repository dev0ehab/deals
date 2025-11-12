<?php

namespace App\Enums;

use Kongulov\Traits\InteractWithEnum;


enum OrderStatusEnum: string
{
    use InteractWithEnum;


    case PREPAID        = 'prePaid';
    case PENDING        = 'pending';
    case PROCESSING     = 'processing';
    case READY          = 'ready';
    case TRANSIT        = 'transit';
    case DELIVERED      = 'delivered';
    case CANCELLED      = 'cancelled';
    case REJECTED       = 'rejected';
    case REFUNDED       = 'refunded';


    public static function colors($status)
    {
        $colors = [
            self::PREPAID->value        => "#00005d",
            self::PENDING->value        => "#05545d",
            self::PROCESSING->value     => "#055aed",
            self::READY->value          => "#cf0404",
            self::TRANSIT->value        => "#cf04q4",
            self::DELIVERED->value      => "#055wed",
            self::CANCELLED->value      => "#cf0435",
            self::REJECTED->value       => "#gf2035",
            self::REFUNDED->value       => "#wf0435",
        ];

        return data_get($colors, $status, null);
    }

    public static function nextStatus($status)
    {
        $colors = [
            self::PENDING->value => [
                self::PROCESSING->value,
                self::REJECTED->value,
            ],
            self::PROCESSING->value => self::READY->value,
            self::READY->value      => self::TRANSIT->value,
            self::TRANSIT->value    => self::DELIVERED->value,
            self::DELIVERED->value  => null,
            self::CANCELLED->value  => null,
        ];

        return data_get($colors, $status, null);
    }

    public static function translatedName($status)
    {
        return trans("orders::orders.status.{$status}");
    }
}

