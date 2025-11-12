<?php

namespace Modules\Features\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Features\Entities\Video;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        if (isset($this->resource['mime_type'])) {
            $media = [
                'type' => $this->resource['type'],
                'preview' => $this->resource['preview'],
                'url' => $this->resource['url']
            ];
        } else {
            $media = [
                'type' => 'video',
                'preview' => $this->getImage(),
                'url' => $this->link
            ];
        }

        return $media;
    }
}
