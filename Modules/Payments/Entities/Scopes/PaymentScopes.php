<?php


namespace Modules\Payments\Entities\Scopes;


use Illuminate\Database\Eloquent\Builder;

trait PaymentScopes
{
    /**
     * Scope the query to include only default country.
     *
     * @param Builder $builder
     * @return Builder
     */
    public function scopeActive(Builder $builder)
    {
        return $builder->where('active', true);
    }
}
