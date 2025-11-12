<?php

namespace Modules\Accounts\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'verification_code' => $this->getVerificationCode(),
            'email' => $this->email,
            'avatar' => $this->getAvatar(),
            'balance' => (float) $this->balance,
            'lat' => $this->lat,
            'long' => $this->long,
            'location' => $this->location,
            'created_at' => $this->created_at->toDateTimeString(),
            'created_at_formatted' => $this->created_at->diffForHumans(),
        ];
    }
}
