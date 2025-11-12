<?php

namespace Modules\Notifications\Http\Filters;

use App\Http\Filters\BaseFilters;

class NotificationFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'title',
        'message'
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
            return $this->builder->where('title', 'LIKE', "%$value%");
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given name.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function message($value)
    {
        if ($value) {
            return $this->builder->where('message', 'LIKE', "%$value%");
        }

        return $this->builder;
    }

}
