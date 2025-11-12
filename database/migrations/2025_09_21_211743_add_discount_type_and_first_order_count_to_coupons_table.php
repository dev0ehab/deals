<?php

use App\Enums\CouponDiscountTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountTypeAndFirstOrderCountToCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->enum('discount_type', CouponDiscountTypeEnum::values())->default(CouponDiscountTypeEnum::TOTAL->value)->after('code');
            $table->integer('first_order_count')->nullable()->after('max_usage_per_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn(['discount_type', 'first_order_count']);
        });
    }
}
