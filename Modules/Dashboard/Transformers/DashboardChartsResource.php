<?php

namespace Modules\Dashboard\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardChartsResource extends JsonResource
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
            'orders' => $this['orders'],
            'sales' => $this['sales'],
            'average' => $this['average'],
        ];
    }
}
