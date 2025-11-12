<?php

namespace App\Enums;

use Kongulov\Traits\InteractWithEnum;


enum ServicesEnum: string
{
    use InteractWithEnum;

    case AttachCompany = "1";
    case Shipping = "2";


    /**
     * Get the service name corresponding to the given service ID.
     *
     * @param string $service The service ID.
     * @return string The name of the service.
     */
    public static function serviceName($service)
    {
        $services = [
            "1" => "shipping",
            "2" => "attachCompany",
        ];
        return $services[$service];
    }


    public static function serviceId($service)
    {
        $services = [
            "shipping" => "1",
            "attachCompany" => "2",
        ];
        return $services[$service];
    }


    public static function hasManyImages($service)
    {
        $services = [
            "1" => true,
            "2" => true,
        ];
        return $services[$service];
    }



}
