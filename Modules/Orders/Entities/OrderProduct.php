<?php

namespace Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Products\Entities\Product;

class OrderProduct extends Model
{
    protected $table = 'order_products'; // optional, or just use default

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'total',
        'rate',
        'comment',
        "is_rate_accepted"
    ];

    protected $with = [
        'product',
    ];

    protected $casts = [
        'total'    => 'float',
        'price'    => 'float',
        'quantity' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function isActive()
    {
        return $this->is_rate_accepted == 1;
    }


    public function orderProductFeatures()
    {
        return $this->hasMany(OrderProductFeature::class);
    }
}
