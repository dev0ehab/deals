<?php

namespace Modules\Payments\Http\Filters;

use App\Http\Filters\BaseFilters;
use Illuminate\Database\Eloquent\Builder;

class PaymentFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
    ];

    /**
     * Filter the query by a given name.
     *
     * @param string|int $value
     * @return Builder
     */
    protected function name($value)
    {
        if ($value) {
            return $this->builder->whereTranslationLike('name', "%$value%");
        }

        return $this->builder;
    }
}
