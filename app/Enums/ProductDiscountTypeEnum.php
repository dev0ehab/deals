<?php

namespace App\Enums;

use Kongulov\Traits\InteractWithEnum;

enum ProductDiscountTypeEnum: string
{
    use InteractWithEnum;

    case NONE = 'none';
    case FIXED = 'fixed';
    case OFFER = 'offer';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::NONE => 'None',
            self::FIXED => 'Fixed',
            self::OFFER => 'Offer',
        };
    }

    public static function translatedName($type)
    {
        return trans("products::products.discount_type.{$type}");
    }
}


