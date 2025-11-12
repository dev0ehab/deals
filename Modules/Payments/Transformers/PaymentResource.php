<?php

namespace Modules\Payments\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;


class PaymentResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'active' => $this->active,
            'icon' => $this->getImage(),
        ];
    }
}
