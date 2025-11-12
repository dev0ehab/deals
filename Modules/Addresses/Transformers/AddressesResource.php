<?php

namespace Modules\Addresses\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressesResource extends JsonResource
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
            'building_number'    => (string) $this->building_number,
            'appartement_number' => (string) $this->appartement_number,
            'floor_number'       => (string) $this->floor_number,
            'street_name'        => (string) $this->street_name,
            'description'        => (string) $this->description,
            'landmark'           => (string) $this->landmark,
            'area'               => (string) $this->area,
            'lat'                => (string) $this->lat,
            'long'               => (string) $this->long,
            'type'               => (string) $this->type,
            'address'            => (string) $this->address,
            'is_default'         => (bool) $this->is_default,
            'delivery_price'     => (float) deliveryPriceUnit($this->lat, $this->long),
        ];
    }
}
