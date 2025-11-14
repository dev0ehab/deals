<?php

namespace Modules\Vendors\Transformers;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Accounts\Entities\ResetPasswordCode;

class VendorsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $code = $this->verification;
        $r_code = ResetPasswordCode::where('username', $this->phone)->first();
        if ($code) {
            $vendorCode = $code->code;
        } elseif ($r_code) {
            $vendorCode = $r_code->code;
        } else {
            $vendorCode = '';
        }
        $data = [
            'id'                   => $this->id,
            'name'                 => $this->name,
            'phone'                => $this->phone,
            'email'                => $this->email,
            'code'                 => $vendorCode,
            'avatar'               => $this->getAvatar(),
            'device_token'         => $this->device_token,
            // 'token'                => $this->createTokenForDevice($request->device_name),
            'reset_token'          => $this->reset_token ?: '',
            'verified'             => $this->hasVerifiedPhone(),
            'verified_at'          => Carbon::parse($this->phone_verified_at)->format('d/m/Y H:i'),
            'created_at'           => Carbon::parse($this->created_at)->format('d/m/Y H:i'),
            'created_at_formatted' => $this->created_at->diffForHumans(),
        ];

        return $data;
    }
}
