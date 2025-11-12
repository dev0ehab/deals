<?php

namespace Modules\Accounts\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Accounts\Entities\User;

class FollowerUserResource extends JsonResource
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
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
        ];

        if (get_class($this->resource) == "stdClass") {
            $user = User::find($this->id);
            $data['avatar'] = $user->getAvatar();
        }else{
            $data['avatar'] = $this->getAvatar();
        }

        return $data;
    }
}
