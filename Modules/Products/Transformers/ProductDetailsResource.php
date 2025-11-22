<?php

namespace Modules\Products\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Products\Entities\Product;
use Modules\Sections\Transformers\SectionsResource;

class ProductDetailsResource extends JsonResource
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
            'id'               => $this->id,
            'name'             => $this->name,
            'description'      => $this->description,
            'cover'            => $this->cover,
            'images'           => $this->images->pluck('url')->toArray(),
            'price'            => (float) $this->price,
            'old_price'        => $this->old_price ? (float) $this->old_price : null,
            'section'          => new SectionsResource($this->whenLoaded("section")),
            'stock'            => (int) $this->stock,
            'rate'             => (int) $this->rate,
            'rates_count'      => (int) $this->rates_count,
            "section_id"       => $this->section->id,
            "section_name"     => $this->section->name,
            'rates'            => ProductRatesResource::collection($this->rates),
            'similar_products' => ProductsResource::collection(Product::where('section_id', $this->section_id)->where('id', '!=', $this->id)->limit(5)->get()),
        ];
    }
}
