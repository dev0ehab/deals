<?php

namespace Modules\Dashboard\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardCardsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            // start cards
            'orders_count' => $this['ordersCount'],
            'total_sales' => number_format($this['totalSales'], 2),
            'average_orders' => number_format($this['averageOrders'], 2),
            'day_orders_count' => $this['todayOrdersCount'] ?? null,
            'day_total_sales' => isset($this['todayTotalSales']) ? number_format($this['todayTotalSales'], 2) : null,
            'day_average_orders' => isset($this['todayAverageOrders']) ? number_format($this['todayAverageOrders'], 2) : null,
            // end cards

            // start charts
            'orders' => $this['orders'],
            'sales' => $this['sales'],
            'average' => $this['average'],
            // end charts
        ];
    }
}
