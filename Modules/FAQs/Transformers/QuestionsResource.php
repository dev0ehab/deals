<?php

namespace Modules\FAQs\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionsResource extends JsonResource
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
            'id' => $this->id,
            'question' => $this->question,
            'answer' => $this->answer,
        ];
    }
}
