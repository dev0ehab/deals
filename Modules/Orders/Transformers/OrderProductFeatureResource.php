<?php

namespace Modules\Orders\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductFeatureResource extends JsonResource
{

    public function toArray($request)
    {
        $lang = app()->getLocale();
        return [
            "feature" => $this->productFeature?->{"text_{$lang}"},
            "option"  => $this->option_product,
            "image"   => $this->image,
        ];

    }
}
