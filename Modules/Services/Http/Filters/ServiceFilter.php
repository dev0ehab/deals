<?php

namespace Modules\Services\Http\Filters;

use App\Http\Filters\BaseFilters;

class ServiceFilter extends BaseFilters
{

    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'main_service',
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
     * Filter The query by main service.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */


    protected function mainService($value)
    {
        if ($value) {
            return $this->builder->parentService();
        }
        return $this->builder;
    }


}
