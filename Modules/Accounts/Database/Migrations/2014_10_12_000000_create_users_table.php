<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Companies\Entities\Company;
use Modules\Vendors\Entities\Vendor;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('l_name')->nullable();
            $table->string('type')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('blocked_at')->nullable();
            $table->rememberToken();
            $table->datetime('last_login_at')->nullable();
            $table->string('device_token')->nullable();
            $table->string('preferred_locale')->nullable();
            $table->string('location')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->float('balance')->default(0);
            $table->boolean('belongs_to_vendor')->default(false);
            $table->boolean('order_notification')->default(true);
            $table->string('facebook_id')->unique()->nullable();
            $table->string('google_id')->unique()->nullable();
            $table->string('apple_id')->unique()->nullable();

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
        Schema::dropIfExists('users');
    }
}
