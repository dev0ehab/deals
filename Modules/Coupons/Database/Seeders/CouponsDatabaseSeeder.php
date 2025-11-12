<?php

namespace Modules\Coupons\Database\Seeders;

use Illuminate\Database\Seeder;

class CouponsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coupon = \Modules\Coupons\Entities\Coupon::create([
            'code'                => 'total-3',
            'description'         => 'Get 10% off on your total order with this special coupon',
            'percentage_discount' => 10,
            'max_discount'        => 50,
            'start_at'            => \Carbon\Carbon::now(),
            'expire_at'           => \Carbon\Carbon::now()->addMonth(),
            'max_usage'           => 100,
            'max_usage_per_user'  => 3,
            'active'              => true,
            'first_order_count'   => 3,
            'discount_type'       => \App\Enums\CouponDiscountTypeEnum::TOTAL,
            'users'               => json_encode([]),
            'audience'            => \App\Enums\AudienceEnum::All,
        ]);

        $coupon = \Modules\Coupons\Entities\Coupon::create([
            'code'                => 'delivery-3',
            'description'         => 'Free delivery on your order with this coupon code',
            'percentage_discount' => 100,
            'max_discount'        => 150,
            'start_at'            => \Carbon\Carbon::now(),
            'expire_at'           => \Carbon\Carbon::now()->addMonth(),
            'max_usage'           => 150,
            'max_usage_per_user'  => 2,
            'active'              => true,
            'first_order_count'   => null,
            'discount_type'       => \App\Enums\CouponDiscountTypeEnum::DELIVERY,
            'users'               => json_encode([]),
            'audience'            => \App\Enums\AudienceEnum::All,
        ]);
    }}
