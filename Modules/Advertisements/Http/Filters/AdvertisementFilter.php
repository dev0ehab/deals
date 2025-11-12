<?php

namespace Modules\Advertisements\Http\Filters;

use App\Http\Filters\BaseFilters;

class AdvertisementFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'title',
        'description',
        'washer',
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

    /**
     * Filter the query by a given washer id.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function washer($value)
    {
        if ($value) {
            return $this->builder->where('washer_id', $value);
        }

        return $this->builder;
    }

}
