<?php

namespace Modules\Products\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Products\Transformers\ProductFeaturesResource;
use Modules\Sections\Transformers\SectionsResource;

class ProductRatesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        return  [
            'name'    => $this->order->user->name,
            'image'   => $this->order->user->avatar,
            'rate'    => (int) $this->rate,
            'comment' => $this->comment,
        ];
    }
}
