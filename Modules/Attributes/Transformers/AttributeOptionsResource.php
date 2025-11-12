<?php

namespace Modules\Attributes\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AttributeOptionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                 => $this->id,
            'title'              => $this->name,
            'icon'               => $this->icon_url,
            'image'              => $this->image_url,
            'is_default'         => $this->is_default,
            'paper_count_factor' => $this->paper_count_factor,
            'price'              => $this->price,
        ];
    }
}
