<?php

namespace Modules\Coupons\Entities\Helpers;

use App\Enums\OrderStatusEnum;
use Carbon\Carbon;
use Modules\Accounts\Entities\User;
use Modules\Coupons\Transformers\CouponResource;

trait CouponHelper
{
    /**
     *
     * @return bool
     */
    public function isActive()
    {
        if ($this->active == 1) {
            return true;
        }
        return false;
    }

    /**
     *
     * @return bool
     */
    public function isExpired()
    {
        if ($this->expire_at->format('Y-m-d') >= date('Y-m-d')) {
            return true;
        }
        return false;
    }

    /**
     * Get the resource for coupon.
     *
     * @return CouponResource
     */
    public function getResource()
    {
        return new CouponResource($this);
    }


    /**
     * @return int
     * @throws \Exception
     */
    public function getDurationAttribute()
    {
        $from = Carbon::parse($this->start_at);
        $to = Carbon::parse($this->expire_at);
        $diff_in_days = $to->diffInDays($from);
        return $diff_in_days;
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function getRemainingDurationAttribute()
    {
        $to = Carbon::parse($this->expire_at);
        $from = Carbon::parse(Carbon::now());
        $diff_in_days = $to->diffInDays($from);

        return $from > $to ? 0 : $diff_in_days;
    }

    /**
     * @param $basic
     * @return float|int
     */
    public function applyBasicDiscount($basic)
    {
        // Backward compatibility: if coupon_type is null, assume percent (old behavior)
        $couponType = $this->coupon_type ?? 'percent';

        if ($couponType === 'fixed') {
            $discount = min($this->max_discount, $basic);
        } else {
            // percent type
            $discount = ($this->percentage_discount / 100) * $basic;
            $discount = min($this->max_discount, $discount);
        }

        return $discount;
    }

    /**
     * Get discount type label
     * @return string
     */
    public function getDiscountTypeLabelAttribute()
    {
        return match($this->discount_type) {
            'delivery' => 'Delivery',
            'total' => 'Total Order',
            default => 'Unknown'
        };
    }

    /**
     * Check if coupon is valid for first order count
     * @return bool
     */
    public function isValidForFirstOrderCount()
    {
        if (!$this->first_order_count) {
            return true; // No limit set
        }

        return $this->consumtionsCountPerUser() < $this->first_order_count;
    }


    public function getUsersModelAttribute()
    {
        return User::wherein("id", $this->users ?? [])->get();
    }

    public function getConsumtionsCountPerUserAttribute()
    {
        return $this->consumtionsCount(user() ? user() : null);
    }

    public function getConsumtionsCountAttribute()
    {
        return $this->consumtionsCount();
    }

    public function consumtionsCount($user = null)
    {
        $couponOrderCount = $this->couponOrders()->statusNotIn([OrderStatusEnum::CANCELLED->value, OrderStatusEnum::REFUNDED->value])->when($user, fn($q) => $q->where('user_id', $user->id))->count();

        return $couponOrderCount;
    }
}
