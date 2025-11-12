<?php

namespace App\Enums;
use Kongulov\Traits\InteractWithEnum;


enum AddressTypesEnum: string
{
    use InteractWithEnum;

    case Home = "home";
    case Office = "office";
    case Other = "other";
}
