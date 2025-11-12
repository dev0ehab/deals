<?php

namespace Modules\Products\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
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
            'id'           => $this->id,
            'name'         => $this->name,
            'description'  => $this->description,
            'cover'        => $this->cover,
            'price'        => (float) $this->price,
            'old_price'    => $this->old_price ? (float) $this->old_price : null,
            'stock'        => (int) $this->stock,
            'rate'         => (int) $this->rate,
            "section_id"   => $this->section->id,
            "section_name" => $this->section->name,
        ];
    }
}
