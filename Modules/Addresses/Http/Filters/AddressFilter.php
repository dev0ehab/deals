<?php

namespace Modules\Addresses\Http\Filters;

use App\Http\Filters\BaseFilters;

class AddressFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'address',
    ];

    /**
     * Filter the query by a given address.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function address($value)
    {
        if ($value) {
            return $this->builder->where('address', 'like', "%$value%");
        }

        return $this->builder;
    }

}
