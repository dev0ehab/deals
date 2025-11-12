<?php

namespace Modules\Coupons\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Vendors\Entities\Vendor;

class CouponFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Coupons\Entities\Coupon::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code'                => 'sale-' . $this->faker->numberBetween(50, 500),
            'description'         => $this->faker->sentence(10),
            'percentage_discount' => $this->faker->numberBetween(50, 500),
            'start_at'            => now(),
            'expire_at'           => now()->addMonths(2),
            'number'              => $this->faker->numberBetween(50, 500),
            'max_usage_per_user'  => $this->faker->numberBetween(1, 10),
            'min_total'           => $this->faker->numberBetween(1, 500),
        ];
    }
}

