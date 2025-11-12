<?php

namespace Modules\Areas\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AreasResource extends JsonResource
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
            'id'        => $this->id,
            'name'      => $this->name,
            'waypoints' => $this->waypoints,
            'price'     => $this->price,
        ];
    }
}
