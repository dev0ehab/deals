<?php

namespace Modules\Services\Transformers;

use App\Enums\ServicesEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceBriefResource extends JsonResource
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
            'id'          => $this->id,
            'type'        => ServicesEnum::serviceName($this->id),
            'name'        => $this->name,
            'title'       => $this->title,
            'cover'       => $this->cover,
            'price'       => $this->price,
        ];
    }
}
