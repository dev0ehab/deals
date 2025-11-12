<?php

namespace Modules\Orders\Http\Filters;

use App\Http\Filters\BaseFilters;

class OrderFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'id',
        'name',
        'phone',
        'email',
        'status',
    ];

    /**
     * Filter the query by a given id.
     *
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function id($value)
    {
        if ($value) {
            return $this->builder->where('id', $value);
        }
        return $this->builder;
    }


    /**
     * Filter the query by a given user.
     *
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function name($value)
    {
        if ($value) {
            return $this->builder->where('name', "like", "%$value%");
        }
        return $this->builder;
    }


    /**
     * Filter the query by a given user.
     *
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function phone($value)
    {
        if ($value) {
            return $this->builder->where('phone', "like", "%$value%");
        }
        return $this->builder;
    }


    /**
     * Filter the query by a given user.
     *
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function email($value)
    {
        if ($value) {
            return $this->builder->where('email', "like", "%$value%");
        }
        return $this->builder;
    }


    /**
     * Filter the query by a given status.
     *
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function status($value)
    {
        if ($value && gettype($value) == "string") {
            $value = explode(",", $value);
            return $this->builder->whereIn("status", $value);
        }

        return $this->builder;
    }




}
