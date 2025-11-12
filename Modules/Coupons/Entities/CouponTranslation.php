<?php

namespace Modules\Coupons\Entities;

use Illuminate\Database\Eloquent\Model;

class CouponTranslation extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'description',
    ];

}
