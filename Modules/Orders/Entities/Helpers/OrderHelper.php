<?php

namespace Modules\Orders\Entities\Helpers;

use App\Enums\OrderStatusEnum;
use Modules\Accounts\Entities\User;
use Modules\Workers\Entities\Worker;

trait OrderHelper
{
    /**
     * @return boolean
     */
    public function isStatus($status)
    {
        return $this->status == $status;
    }

    public function getStatusColor()
    {
        return OrderStatusEnum::colors($this->status);
    }

    public function getStatusName()
    {
        return OrderStatusEnum::translatedName($this->status);
    }

    public function getStatus()
    {
        return "<span class='badge text-white' style='background-color: #00005d'>{$this->getStatusName()}</span>";
    }


    public function getImagesAttribute()
    {
        return $this->getMediaResource('images')->pluck("url")->toArray();
    }


    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value;
    }


}
