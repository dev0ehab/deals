<?php

namespace App\Enums;

use Kongulov\Traits\InteractWithEnum;


enum PaymentsEnum: string
{
    use InteractWithEnum;
    case Cash = "1";
    case Electronic = "2";
    case Wallet = "3";


    public static function seeder()
    {
        $data = [

            [
                'id' => self::Electronic->value,
                'name:ar' => 'دفع الكتروني',
                'name:en' => 'Electronic Payment',
                'active' => true,
            ],
            [
                'id' => self::Cash->value,
                'name:ar' => 'الدفع عند الاستلام',
                'name:en' => 'Pay on Delivery',
                'active' => true,
            ],
            [
                'id' => self::Wallet->value,
                'name:ar' => 'الدفع من المحفظة',
                'name:en' => 'Pay from wallet',
                'active' => true,
            ],
        ];

        return $data;
    }


    public static function translatedName($status)
    {
        return trans("packages::packages.status." . $status);
    }
}
