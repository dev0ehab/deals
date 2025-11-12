<?php

namespace App\Enums;

use Kongulov\Traits\InteractWithEnum;


enum AttributePricingEnum: string
{
    use InteractWithEnum;

    case PAPER_PRICE = "paper_price";
    case TOTAL_PRICE = "total_price";
    case NO_PRICE    = "no_price";

    public static function colors($status)
    {
        $colors = [
            self::PAPER_PRICE->value => "#17a2b8",
            self::TOTAL_PRICE->value => "#ffc107",
            self::NO_PRICE->value => "#ffc107",
        ];

        return $colors[$status];
    }

    public static function translatedName($status)
    {
        return trans("attributes::attributes.pricing." . $status);
    }
}
