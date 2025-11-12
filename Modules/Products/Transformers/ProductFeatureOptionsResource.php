<?php

namespace Modules\Products\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Features\Transformers\FeatureOptionResource;
use Modules\Features\Transformers\FeatureResource;

class ProductFeatureOptionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'image'           => $this->image,
        ];
    }
}
