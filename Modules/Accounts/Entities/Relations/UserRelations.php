<?php


namespace Modules\Accounts\Entities\Relations;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Accounts\Entities\Verification;
use Modules\Addresses\Entities\Address;
use Modules\Carts\Entities\Cart;
use Modules\Companies\Entities\Company;
use Modules\Orders\Entities\Order;
use Modules\Vendors\Entities\Rate;
use Modules\Vendors\Entities\Vendor;

trait UserRelations
{

    /**
     * Get the user's verification.
     */
    public function verification(): MorphOne
    {
        return $this->morphOne(Verification::class, 'parentable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rates(): HasMany
    {
        return $this->hasMany(Rate::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the vendor that owns the UserRelations
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function cart(): MorphOne
    {
        return $this->morphOne(Cart::class, 'cartable');
    }

}
