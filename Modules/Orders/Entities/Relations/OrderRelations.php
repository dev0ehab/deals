<?php

namespace Modules\Orders\Entities\Relations;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Accounts\Entities\User;
use Modules\Addresses\Entities\Address;
use Modules\Coupons\Entities\Coupon;
use Modules\Orders\Entities\OrderFile;
use Modules\Orders\Entities\OrderProduct;
use Modules\Payments\Entities\Payment;

trait OrderRelations
{
    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Get the files for the order
     *
     * @return HasMany
     */
    public function orderFiles(): HasMany
    {
        return $this->hasMany(OrderFile::class);
    }

    /**
     * Get the coupon for the order
     *
     * @return BelongsTo
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Get the payment for the order
     *
     * @return BelongsTo
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Get the products for the order
     *
     * @return HasMany
     */
    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }
}
