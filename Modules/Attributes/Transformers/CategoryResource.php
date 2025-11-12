<?php

namespace Modules\Attributes\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name'        => $this->name,
            'icon'        => $this->icon,
            'attributes'  => AttributeResource::collection($this->whenLoaded('attributes')),
        ];
    }
}
