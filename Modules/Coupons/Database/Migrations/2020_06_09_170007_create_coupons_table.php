<?php

use App\Enums\AudienceEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Vendors\Entities\Vendor;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->float('percentage_discount');
            $table->float('max_discount');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('expire_at')->nullable();
            $table->integer('max_usage');
            $table->integer('max_usage_per_user');
            $table->boolean('active')->default(true);
            $table->json('users')->nullable();
            $table->enum('audience', AudienceEnum::values())->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('coupons');
    }
}
