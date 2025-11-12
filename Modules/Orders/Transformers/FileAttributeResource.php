<?php

namespace Modules\Orders\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;

class FileAttributeResource extends JsonResource
{


    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'attribute'   => $this->attribute->title,
            'option'      => $this->option_name,
        ];
    }
}
