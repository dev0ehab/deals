<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Coupons\Entities\Coupon;

class AddDescriptionToCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('coupon_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignIdFor(Coupon::class)->constrained()->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->string('locale')->index();
            $table->unique(['coupon_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('coupon_translations');
    }
}
