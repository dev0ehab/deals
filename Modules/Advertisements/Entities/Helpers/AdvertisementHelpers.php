<?php

namespace Modules\Advertisements\Entities\Helpers;

use Modules\Advertisements\Transformers\AdvertisementsResource;

trait AdvertisementHelpers
{

    /**
     * The advertisement image url.
     *
     */
    public function getImage()
    {
        return $this->getFirstMediaUrl('images');
    }

    /**
     *
     * @return bool
     */
    public function isActive()
    {
        if ($this->active == 1) {
            return true;
        }
        return false;
    }


    /**
     * Get the resource for coupon.
     *
     * @return AdvertisementsResource
     */
    public function getResource()
    {
        return new AdvertisementsResource($this);
    }

}
