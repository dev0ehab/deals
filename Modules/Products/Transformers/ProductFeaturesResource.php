<?php

namespace Modules\Products\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Products\Transformers\ProductFeatureOptionsResource;
use Modules\Features\Transformers\FeatureResource;

class ProductFeaturesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $lang = app()->getLocale();
        return [
            'id'              => $this->id,
            'feature_type'    => $this->feature_type,
            'text'            => $this->{"text_{$lang}"},
            'feature_options' => ProductFeatureOptionsResource::collection($this->featureOptions),
            "image"           => $this->image,
        ];
    }
}
