<?php


namespace Modules\Services\Entities\Scopes;

trait ServiceScopes
{
    public function scopeParentService($query)
    {
        return $query->whereNull('parent_id')->orWhere('parent_id', 0);
    }

    public function scopeChildService($query)
    {
        return $query->whereNotNull('parent_id');
    }
}
