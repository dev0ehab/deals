<?php

namespace App\Enums;
use Kongulov\Traits\InteractWithEnum;


enum DeliveryStatusEnum: string
{
    use InteractWithEnum;

    case LICENSE = "license_data";
    case CAR = "car_data";
    case PENDING = "pending";
    case ACCEPTED = "accepted";
    case REJECTED = "rejected";


    public static function colors($status)
    {
        $colors = [
            self::LICENSE->value => "#ccdb21",
            self::CAR->value => "#055aed",
            self::PENDING->value => "#f0ad4e",
            self::ACCEPTED->value => "#5cb85c",
            self::REJECTED->value => "#d9534f",
        ];

        return $colors[$status];
    }

    public static function translatedName($status)
    {
        return trans("deliveries::deliveries.status." . $status);
    }
}
