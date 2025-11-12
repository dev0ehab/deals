<?php

namespace App\Enums;
use Kongulov\Traits\InteractWithEnum;


enum ContactsTypesEnum: string
{
    use InteractWithEnum;

    case User = "user";
    case Vendor = "vendor";
}
