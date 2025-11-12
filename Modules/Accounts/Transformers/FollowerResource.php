<?php

namespace Modules\Accounts\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class FollowerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     * @throws \Laracasts\Presenter\Exceptions\PresenterException
     */
    public function toArray($request)
    {
        return [
            'id' => $this->user->id,
            'name' => $this->user->name,
            'phone' => $this->user->phone,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
            'avatar' => $this->user->getAvatar(),
        ];
    }
}
