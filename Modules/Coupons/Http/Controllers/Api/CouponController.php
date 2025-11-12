<?php

namespace Modules\Coupons\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Modules\Coupons\Http\Requests\Api\ValidateCouponRequest;
use Modules\Coupons\Entities\Coupon;
use Modules\Coupons\Transformers\CouponResource;
use Modules\Support\Traits\ApiTrait;

class CouponController extends Controller
{
    use ApiTrait;

    public function index()
    {
        $coupons = Coupon::where(function ($q) {
            return $q->where('audience', 'specific')->forMe();
        })->orWhere(function ($q) {
            return $q->where('audience', 'all');
        })->whereValid()->active()->firstOrderCount()->get();

        $coupons = $coupons->filter(function ($q) {
            return $q->max_usage > $q->consumptionsCount;
        });

        if (user()) {
            $coupons = $coupons->filter(function ($q) {
                return $q->max_usage_per_user > $q->consumptionsCountPerUser;
            });
        }

        $data = CouponResource::collection($coupons);
        return $this->sendResponse($data, __('Data Found'));
    }

    public function validate(ValidateCouponRequest $request)
    {
        $coupon = Coupon::whereCode($request->coupon_code)->first();


        if (!$coupon) {
            return $this->sendError(trans('coupons::coupons.messages.coupon_invalid'));
        }

        if (!$coupon->active) {
            return $this->sendError(trans('coupons::coupons.messages.coupon_not_active'));
        }

        if (Carbon::now() > $coupon->expire_at) {
            return $this->sendError(trans('coupons::coupons.messages.coupon_total_usage'));
        }

        if (Carbon::now() < $coupon->start_at) {
            return $this->sendError(trans('coupons::coupons.messages.coupon_not_active'));
        }

        // check consumtion for current user
        if ($coupon->max_usage_per_user <= $coupon->consumtionsCountPerUser) {
            return $this->sendError(trans('coupons::coupons.messages.coupon_max_usage_per_user'));
        }

        // check consumtion for the coupon itself
        if ($coupon->max_usage <= $coupon->consumtionsCount) {
            return $this->sendError(trans('coupons::coupons.messages.coupon_max_usage'));
        }

        // check first order count limit
        if (user() && $coupon->first_order_count && $coupon->first_order_count <= user()->orders()->count()) {
            return $this->sendError(trans('coupons::coupons.messages.coupon_first_order_limit_reached'));
        }

        // check first order count limit for specific users
        if (user() && $coupon->audience == 'specific' && $coupon->users && !in_array(user()->id, $coupon->users)) {
            return $this->sendError(trans('coupons::coupons.messages.this_coupon_is_not_for_you'));
        }

        return $this->sendResponse(new CouponResource($coupon), trans('coupons::coupons.messages.coupon_valid'));
    }
}
