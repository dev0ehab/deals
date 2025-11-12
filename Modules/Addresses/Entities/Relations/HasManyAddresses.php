<?php

namespace Modules\Addresses\Entities\Relations;

use Modules\Addresses\Entities\Address;

trait HasManyAddresses
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
