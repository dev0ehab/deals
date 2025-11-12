<?php

namespace Modules\Coupons\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
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
            'id'                  => $this->id,
            'code'                => $this->code,
            'description'         => $this->description,
            'discount_type'       => $this->discount_type,
            'coupon_type'         => $this->coupon_type,
            'used'                => $this->consumtionsCount(),
            'percentage_discount' => $this->percentage_discount,
            'max_discount'        => $this->max_discount,
            'max_usage_per_user'  => $this->max_usage_per_user,
            'first_order_count'   => $this->first_order_count,
            'start_at'            => $this->start_at->toDateString(),
            'expire_at'           => $this->expire_at->toDateString(),
        ];
    }
}
