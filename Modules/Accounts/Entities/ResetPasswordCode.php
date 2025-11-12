<?php

namespace Modules\Accounts\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Deliveries\Entities\Delivery;
use Modules\Vendors\Entities\Vendor;
use Modules\Workers\Entities\Worker;

class ResetPasswordCode extends Model
{
    /**
     * the code expiration by seconds.
     *
     * @var int
     */
    const EXPIRE_DURATION = 10 * 60;

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'code',
        'type',
        'created_at',
    ];

    /**
     * Determine whither this code has been expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->created_at->addSeconds(static::EXPIRE_DURATION)->isPast();
    }

    /**
     * @return BelongsTo
     */
    public function getUserAttribute()
    {
        if ($this->type == "vendor") {
            $class =  Vendor::class;
        } else {
            $class =  User::class;
        }
        return $class::where(function ($query) {
            $query->where('email', $this->username);
            $query->orWhere('phone', $this->username);
        })->first();

    }
}
