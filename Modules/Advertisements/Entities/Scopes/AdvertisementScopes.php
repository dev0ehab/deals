<?php

namespace Modules\Advertisements\Entities\Scopes;

use Carbon\Carbon;

trait AdvertisementScopes
{

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

}
