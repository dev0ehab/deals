<?php

namespace Modules\Products\Http\Filters;

use App\Http\Filters\BaseFilters;
use Illuminate\Support\Facades\DB;

class ProductFilter extends BaseFilters
{
    private $washer;


    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'description',
        "section",
        "sort"
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
            return $this->builder->where('description', 'like', "%$value%");
        }
        return $this->builder;
    }


    protected function section($value)
    {
        if ($value) {
            $idsArray = explode(',', $value);
            return $this->builder->whereIn('section_id', $idsArray);
        }
        return $this->builder;
    }


    protected function sort($value)
    {
        switch ($value) {
            case 'newest':
                return $this->builder->orderBy('created_at', 'desc');
            case 'oldest':
                return $this->builder->orderBy('created_at', 'asc');
            case 'highest_price':
                return $this->builder->orderBy('price', 'desc');
            case 'lowest_price':
                return $this->builder->orderBy('price', 'asc');
            case 'highest_rate':
                return $this->builder->orderBy('rate', 'desc');
            case 'lowest_rate':
                return $this->builder->orderBy('rate', 'asc');
            case 'best_selling':
                return $this->builder->select('products.*',DB::raw('COALESCE(SUM(order_products.quantity), 0) as total_sold'))
                ->leftJoin('order_products', 'order_products.product_id', '=', 'products.id')
                ->leftJoin('orders', 'orders.id', '=', 'order_products.order_id')
                ->groupBy('products.id')
                ->orderByDesc('total_sold');
            default:
                return $this->builder;
        }
    }

}
