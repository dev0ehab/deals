<?php

namespace Modules\Coupons\Repositories;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Modules\Contracts\CrudRepository;
use Modules\Coupons\Entities\Coupon;
use Modules\Coupons\Http\Controllers\Api\CouponController;
use Modules\Coupons\Http\Filters\CouponFilter;
use Modules\Coupons\Http\Requests\Api\ValidateCouponRequest;

class CouponRepository implements CrudRepository
{
    private $filter;

    /**
     * SubscriptionRepository constructor.
     * @param CouponFilter $filter
     */
    public function __construct(CouponFilter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function all()
    {
        return Coupon::latest()->filter($this->filter)->paginate(request('perPage'));
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data)
    {
        $coupon = Coupon::create($data);

        return $coupon;
    }

    /**
     * @param mixed $model
     * @return Model|void
     */
    public function find($model)
    {
        if ($model instanceof Coupon) {
            return $model;
        }

        return Coupon::findOrFail($model);
    }

    /**
     * @param mixed $model
     * @param array $data
     * @return Model|Coupon|void
     */
    public function update($model, array $data)
    {
        $coupon = $this->find($model);

        $coupon->update($data);

        return $coupon;
    }

    /**
     * @param mixed $model
     * @throws Exception
     */
    public function delete($model)
    {
        $this->find($model)->delete();
    }


    public function applyCoupon($code, $total, $order_id = null): array
    {
        $coupon = Coupon::whereCode($code)->first();

        $request = new ValidateCouponRequest(['coupon_code' => $code, 'order_id' => $order_id]);
        $copounController = new CouponController();
        $response = $copounController->validate($request);

        if ($response->status() != 200) {
            throw new Exception(json_decode($response->content())->message);
        }

        // Calculate discount based on coupon type
        // Backward compatibility: if coupon_type is null, assume percent (old behavior)
        $couponType = $coupon->coupon_type ?? 'percent';

        if ($couponType === 'fixed') {
            $discount = min($coupon->max_discount, $total);
        } else {
            // percent type
            $discount = min($coupon->max_discount, ($total * $coupon->percentage_discount / 100));
        }

        return [
            round($discount, 2),
            $coupon->id,
            $coupon->discount_type
        ];
    }


}
