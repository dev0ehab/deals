<?php

namespace Modules\Orders\Transformers;

use App\Enums\OrderStatusEnum;
use Modules\Coupons\Transformers\CouponResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Addresses\Transformers\AddressesResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */

    public $paymentUrl = null;

    public function setPaymentUrl($paymentUrl)
    {
        $this->paymentUrl = $paymentUrl;
        return $this;
    }


    public function toArray($request)
    {
        $data = [
            'id'                 => $this->id,
            'sub_total'          => $this->sub_total,
            'tax'                => $this->tax,
            'discount'           => $this->discount,
            'delivery_fee'       => $this->delivery_fee,
            'bulk_discount'      => $this->bulk_discount,
            'total'              => $this->total,
            "payment"            => $this->payment->name,
            'address'            => AddressesResource::make($this->address),
            'coupon'             => CouponResource::make($this->coupon),
            'delivery_type'      => $this->delivery_type,
            'status'             => $this->status,
            'files'              => OrderFileResource::collection($this->orderFiles),
            'payment_url'        => $this->paymentUrl,
            'created_at'         => $this->created_at,
            'products'           => OrderProductResource::collection($this->orderProducts),
            'total_products'     => $this->orderProducts->count(),
            'total_files'        => $this->orderFiles->count(),
            "products_sub_total" => $this->orderProducts->sum('total'),
            "files_sub_total"    => $this->orderFiles->sum('sub_total'),
            'print_rate'         => $this->print_rate,
        ];

        if ($this->isStatus(OrderStatusEnum::CANCELLED->value)) {
            $data['cancel_reason'] = (string) $this->cancel_reason;
        }

        return $data;
    }
}
