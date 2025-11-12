<?php

namespace Modules\Attributes\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AttributeResource extends JsonResource
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
            'id'           => $this->id,
            'title'        => $this->title,
            'description'  => $this->description,
            'type'         => $this->type,
            'pricing_type' => $this->pricing_type,
            'options'      => AttributeOptionsResource::collection($this->whenLoaded('options')),
        ];
    }
}
