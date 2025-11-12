<?php

namespace Modules\Features\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class FeatureDetailsResource extends JsonResource
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
            'name'         => $this->name,
            'description'  => $this->description,
            'brief'        => $this->brief,
            'image'        => $this->getImage(),
            'cover'        => $this->getCover(),
            'sub_features' => FeatureResource::collection($this->subFeatures),
            'reasons'      => ReasonsResource::collection($this->reasons),
        ];
    }
}
