<?php


namespace Modules\Coupons\Entities\Scopes;


use Illuminate\Database\Eloquent\Builder;

trait CouponScopes
{
    /**
     * @param Builder $builder
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeWhereValid(Builder $builder)
    {
        return $builder->whereDate('expire_at', '>=', now())
        ->whereDate('start_at', '<=', now());

    }


    /**
     * @param Builder $builder
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeForMe(Builder $builder)
    {
        if (user()) {
            return $builder->whereJsonContains('users',  strval(user()->id));
        }
        return $builder;
    }

    /**
     * @param Builder $builder
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeActive(Builder $builder)
    {
        return $builder->where('active', true);
    }

    /**
     * @param Builder $builder
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeGeneral(Builder $builder)
    {
        return $builder->where('audience', 'all');
    }

    /**
     * @param Builder $builder
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeFirstOrderCount(Builder $builder)
    {
        if (user()) {
            return $builder->where('first_order_count', '>', user()->orders()->count())->orWhere('first_order_count', null);
        }
        return $builder;
    }


}
