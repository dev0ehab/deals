<?php

namespace App\Enums;
use Kongulov\Traits\InteractWithEnum;


enum AudienceEnum: string
{
    use InteractWithEnum;

    case All = "all";
    case Specific = "specific";
}
