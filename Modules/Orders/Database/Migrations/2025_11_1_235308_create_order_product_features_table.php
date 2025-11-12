<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Orders\Entities\OrderProduct;
use Modules\Products\Entities\ProductFeature;
use Modules\Features\Entities\FeatureOption;

class CreateOrderProductFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product_features', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(OrderProduct::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(ProductFeature::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(FeatureOption::class)->nullable()->constrained()->cascadeOnDelete();
            $table->text('option')->nullable();
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
        Schema::dropIfExists('order_products');
    }
}
