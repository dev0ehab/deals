<?php

namespace Modules\Accounts\Transformers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Laracasts\Presenter\Exceptions\PresenterException;
use Modules\Accounts\Entities\ResetPasswordCode;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     * @throws PresenterException
     */
    public function toArray($request)
    {
        // $code = $this->verification;
        // $r_code = ResetPasswordCode::where('username', $this->phone)->first();
        // if ($code) {
        //     $userCode = $code->code;
        // } elseif ($r_code) {
        //     $userCode = $r_code->code;
        // } else {
        //     $userCode = '';
        // }
        $data = [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'email'                 => $this->email,
            'phone'                 => $this->phone,
            'address'               => $this->mainAddress,
            'has_social_identifier' => $this->has_social_identifier,
            'avatar'                => $this->getAvatar(),
            'device_token'          => (string) $this->device_token,
            'reset_token'           => (string) $this->reset_token,
            'phone_verified'        => $this->hasVerifiedPhone(),
            'email_verified'        => $this->hasVerifiedEmail(),
            'balance'               => (float) $this->balance,
            // 'code' => $userCode,
            // 'order_notification' => (bool) $this->order_notification,
        ];

        return $data;
    }
}
