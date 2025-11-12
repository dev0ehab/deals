<?php

namespace Modules\Features\Http\Filters;

use App\Http\Filters\BaseFilters;

class FeatureFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'description',
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
     * Filter the query by a given description.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function description($value)
    {
        if ($value) {
            return $this->builder->whereTranslationLike('description', "%$value%");
        }

        return $this->builder;
    }
}
