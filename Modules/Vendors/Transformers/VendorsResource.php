<?php

namespace Modules\Vendors\Transformers;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Accounts\Entities\ResetPasswordCode;
use Modules\Sections\Transformers\SectionsResource;

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
        $code   = $this->verification;
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
            'reset_token'          => $this->reset_token ?: '',
            'verified'             => $this->hasVerifiedPhone(),
            'verified_at'          => Carbon::parse($this->phone_verified_at)->format('d/m/Y H:i'),
            'created_at'           => Carbon::parse($this->created_at)->format('d/m/Y H:i'),
            'created_at_formatted' => $this->created_at->diffForHumans(),
            'is_accepted'          => is_null($this->is_accepted) ? false : $this->is_accepted == 1,
        ];


        if ($this->is_accepted) {
            $data['store_name']           = $this->store_name;
            $data['store_description_ar'] = $this->store_description_ar;
            $data['store_description_en'] = $this->store_description_en;
            $data['sections']             = SectionsResource::collection($this->sections);
            $data['logo']    = $this->logo;
            $data['banners'] = $this->banners->pluck('url')->toArray();
        }


        if ($this->is_accepted == false) {
            $data['rejection_reason'] = $this->rejection_reason;
        }

        return $data;
    }
}
