<?php

namespace Modules\Accounts\Http\Filters;

use App\Http\Filters\BaseFilters;
use Modules\Products\Entities\Product;

class RateFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'product',
    ];

    /**
     * Filter the query to include users by vendor.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function product($value)
    {
        if ($value) {
            return $this->builder->where('rateable_type', Product::class)
            ->where('rateable_id', $value);
        }

        return $this->builder;
    }
}
