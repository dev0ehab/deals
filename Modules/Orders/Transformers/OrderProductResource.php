<?php

namespace Modules\Orders\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Products\Transformers\ProductsResource;

class OrderProductResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'quantity' => $this->quantity,
            'price'    => $this->price,
            'total'    => $this->total,
            'product'  => ProductsResource::make($this->product),
            'rate'     => $this->rate,
            'comment'  => $this->comment,
            'features' => OrderProductFeatureResource::collection($this->orderProductFeatures),
        ];

    }
}
