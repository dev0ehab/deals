<?php

namespace Modules\Orders\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderFileResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'paper_price'  => $this->paper_price,
            "papers_count" => $this->real_paper_count,
            "paper_count"  => $this->real_paper_count,
            "copies_count" => $this->copies,
            'sub_total'    => $this->sub_total,
            'addons'       => $this->addons,
            'total'        => $this->total,
            'file'         => $this->file,
            'attributes'   => FileAttributeResource::collection($this->fileAttributes),
        ];

    }
}
