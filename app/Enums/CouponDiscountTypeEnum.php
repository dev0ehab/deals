<?php

namespace App\Enums;

enum CouponDiscountTypeEnum: string
{
    case DELIVERY = 'delivery';
    case TOTAL = 'total';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::DELIVERY => 'Delivery',
            self::TOTAL => 'Total Order',
        };
    }
}
