<?php


namespace Modules\Coupons\Entities\Relations;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Orders\Entities\Order;

trait CouponRelations
{

    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    /**
     * Get all of the couponOrders for the CouponRelations
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function couponOrders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

}
