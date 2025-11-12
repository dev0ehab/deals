<?php

namespace Modules\Attributes\Http\Filters;

use App\Http\Filters\BaseFilters;

class SelectFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'title',
    ];

    /**
     * Filter the query by a given name.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function title($value)
    {
        if ($value) {
            return $this->builder->whereTranslationLike('title', "%$value%");
        }

        return $this->builder;
    }

}
