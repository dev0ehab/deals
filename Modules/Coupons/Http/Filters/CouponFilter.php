<?php

namespace Modules\Coupons\Http\Filters;

use App\Http\Filters\BaseFilters;

class CouponFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'code',
        'vendor',
        'start',
        'expire',
        'active',
    ];

    /**
     * Filter the query by a given code.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function code($value)
    {
        if ($value) {
            return $this->builder->where('code', 'like', "%$value%");
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given vendor id.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function vendor($value)
    {
        if ($value) {
            return $this->builder->where('vendor_id', $value);
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given start date.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function start($value)
    {
        if ($value) {
            return $this->builder->whereDate('start_at', $value);
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given expire date.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function expire($value)
    {
        if ($value) {
            return $this->builder->whereDate('expire_at', $value);
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given expire date.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function active($value)
    {
        if ($value) {
            return $this->builder->whereDate('expire_at', ">", now());
        }

        return $this->builder;
    }
}
