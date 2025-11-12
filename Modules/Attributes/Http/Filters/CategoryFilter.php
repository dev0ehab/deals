<?php

namespace Modules\Attributes\Http\Filters;

use App\Http\Filters\BaseFilters;

class CategoryFilter extends BaseFilters
{
    /**
     * @param $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function name($value)
    {
        return $this->builder->where('name', 'like', "%{$value}%");
    }

    /**
     * @param $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function is_active($value)
    {
        return $this->builder->where('is_active', $value);
    }

    /**
     * @param $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function rank($value)
    {
        return $this->builder->where('rank', $value);
    }
}
