<?php

namespace Modules\Coupons\Entities;

use App\Http\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Coupons\Entities\Helpers\CouponHelper;
use Modules\Coupons\Entities\Relations\CouponRelations;
use Modules\Coupons\Entities\Scopes\CouponScopes;
use Astrotomic\Translatable\Translatable;

class Coupon extends Model
{
    use Filterable,
        SoftDeletes,
        CouponRelations,
        CouponScopes,
        Translatable,
        CouponHelper;

    /**
     * @var string[]
     */
    protected $dates = ['start_at', 'expire_at'];

    public $translatedAttributes = ['description'];

    protected $with = [
        'translations',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'washer_id',
        'code',
        'description',
        'discount_type',
        'coupon_type',
        'percentage_discount',
        'max_discount',

        'max_usage_per_user',
        'max_usage',
        'first_order_count',

        'start_at',
        'expire_at',

        'audience',

        'active',
        'users',
    ];


    /**
     * @var string[]
     */
    protected $casts = [
        'discount_type'       => 'string',
        'coupon_type'         => 'string',
        'percentage_discount' => 'float',
        'first_order_count'   => 'integer',
        'users'               => 'array',
    ];

    /**
     * @var string[]
     */
    protected $appends = ['duration', 'remaining_duration'];

}
