<?php


namespace Modules\Addresses\Entities\Scopes;


use Illuminate\Database\Eloquent\Builder;

trait AddressScopes
{
    /**
     * Scope the query to include only default country.
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopeDefault(Builder $builder)
    {
        return $builder->where('user_id', auth('api')->id())->where('is_default', true);
    }
}
