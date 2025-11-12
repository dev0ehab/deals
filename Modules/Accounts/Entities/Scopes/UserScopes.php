<?php

namespace Modules\Accounts\Entities\Scopes;

trait UserScopes
{
    public function scopeClient($query)
    {
        return $query->where('id', '!=', 1)->where('type', null);
    }

}
