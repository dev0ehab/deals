<?php

namespace Modules\Vendors\Http\Filters;

use App\Http\Filters\BaseFilters;

class VendorFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'search',
        'phone',
        'company',
    ];

    /**
     * Filter the query by a given name.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function name($value)
    {
        if ($value) {
            return $this->builder->where('name', 'like', "%$value%");
        }

        return $this->builder;
    }

    /**
     * search in vendor.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function search($value)
    {
        if ($value) {
            return $this->builder->where('name', 'like', "%$value%");
        }

        return $this->builder;
    }


    /**
     * Filter the query to include users by phone.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function phone($value)
    {
        if ($value) {
            return $this->builder->where('phone', 'like', "%$value%");
        }

        return $this->builder;
    }


    /**
     * Filter the query by a given company_id.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function company($value)
    {
        if ($value) {
            return $this->builder->where('company_id', $value);
        }

        return $this->builder;
    }

}
