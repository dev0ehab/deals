<?php

namespace App\Enums;

use Kongulov\Traits\InteractWithEnum;


enum DeliveryTypeEnum: string
{
    use InteractWithEnum;

    case DELIVERY       = "delivery";
    case PICKUP   = "pickup";


    public static function colors($status)
    {
        $colors = [
            self::DELIVERY->value => "#00005d",
            self::PICKUP->value   => "#05545d",
        ];

        return data_get($colors, $status, null);
    }


    public static function translatedName($status)
    {
        return trans("orders::orders.delivery_type.{$status}");
    }
}

