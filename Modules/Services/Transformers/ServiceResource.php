<?php

namespace Modules\Services\Transformers;


class ServiceResource extends ServiceBriefResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return  array_merge(parent::toArray($request), [
            'images'      => $this->Images->pluck("url")->toArray(),
            "description" => $this->description
        ]);
    }
}
