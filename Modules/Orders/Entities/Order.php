<?php

namespace Modules\Orders\Entities;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Orders\Entities\Helpers\OrderHelper;
use Modules\Orders\Entities\Relations\OrderRelations;
use Modules\Orders\Entities\Scopes\OrderScopes;
use Modules\Orders\Transformers\OrderResource;
use Modules\Support\Traits\MediaTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Order extends Model implements HasMedia
 {
    use OrderRelations, Filterable, HasFactory, OrderScopes, OrderHelper , InteractsWithMedia , MediaTrait;

    /**
     * @var string[]
     */
    protected $fillable = [
        'total',
        'sub_total',
        'tax',
        'discount',
        'delivery_fee',
        'coupon_id',
        'invoice_id',
        'bulk_discount',
        'payment_id',
        'is_refunded',
        'delivery_type',
        'address_id',
        'user_id',
        'status',
        'cancel_reason',
        "print_rate"
    ];

    protected $casts = [
        'sub_total'     => 'float',
        'tax'           => 'float',
        'discount'      => 'float',
        'delivery_fee'  => 'float',
        'total'         => 'float',
        'bulk_discount' => 'float',
    ];

    /**
     * Get the resource for order.
     *
     * @return OrderResource
     */
    public function getResource()
    {
        return new OrderResource($this);
    }
}
