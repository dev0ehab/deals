<?php

use App\Enums\DeliveryTypeEnum;
use App\Enums\OrderStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Accounts\Entities\User;
use Modules\Addresses\Entities\Address;
use Modules\Coupons\Entities\Coupon;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Coupon::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Address::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('payment_id')->nullable();
            $table->boolean('is_refunded')->default(false);
            $table->string('invoice_id')->nullable();

            $table->decimal('sub_total', 8, 2);
            $table->decimal('delivery_fee', 8, 2);
            $table->decimal('tax', 8, 2);
            $table->decimal('discount', 8, 2)->default(0);
            $table->decimal('bulk_discount', 8, 2)->default(0);
            $table->decimal('total', 8, 2);
            $table->decimal('print_rate', 8, 2)->nullable();

            $table->text('cancel_reason')->nullable();
            $table->enum('status', OrderStatusEnum::values())->default(OrderStatusEnum::PENDING->value);
            $table->enum('delivery_type', DeliveryTypeEnum::values());

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
