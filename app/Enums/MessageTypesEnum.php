<?php

namespace App\Enums;

use Kongulov\Traits\InteractWithEnum;


enum MessageTypesEnum: string
{
    use InteractWithEnum;

    case Text     = "text";
    case Image    = "image";
    case File     = "file";
    case Audio    = "audio";
    case Video    = "video";
    case Contact  = "contact";
    case Location = "location";




    public static function files()
    {
        return [
            self::Image->value,
            self::File->value,
            self::Audio->value,
            self::Video->value,
        ];
    }

    public static function messages()
    {
        return [
            self::Location->value,
            self::Text->value,
            self::Contact->value,
        ];
    }
}
