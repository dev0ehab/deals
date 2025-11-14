<?php

namespace Modules\Vendors\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorsBreifResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        $data = [
            'id'     => $this->id,
            'name'   => $this->name,
            'phone'  => $this->phone,
            'avatar' => $this->getAvatar(),
        ];

        return $data;
    }
}
