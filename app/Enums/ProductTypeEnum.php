<?php

namespace App\Enums;

use Kongulov\Traits\InteractWithEnum;

enum ProductTypeEnum: string
{
    use InteractWithEnum;

    case NEW = 'new';
    case PREORDER = 'preorder';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match($this) {
            self::NEW => 'New',
            self::PREORDER => 'Preorder',
        };
    }

    public static function translatedName($type)
    {
        return trans("products::products.product_type.{$type}");
    }
}


