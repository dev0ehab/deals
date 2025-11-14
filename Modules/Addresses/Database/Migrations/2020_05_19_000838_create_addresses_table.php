<?php

use App\Enums\AddressTypesEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Accounts\Entities\User;
use Modules\Areas\Entities\Area;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('building_number')->nullable();
            $table->string('appartement_number')->nullable();
            $table->string('floor_number')->nullable();
            $table->string('street_name');
            $table->string('landmark')->nullable();
            $table->string('area')->nullable();
            // $table->foreignIdFor(Area::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('address')->nullable();
            $table->string('lat');
            $table->string('long');
            $table->string('type')->nullable();
            $table->boolean('is_default')->default(false);
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('addresses');
    }
}
