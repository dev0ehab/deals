<?php

namespace Modules\Attributes\Http\Filters;

use App\Http\Filters\BaseFilters;

class AttributeFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'vendor',
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
            return $this->builder->whereTranslationLike('name', "%$value%");
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given name.
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
}
