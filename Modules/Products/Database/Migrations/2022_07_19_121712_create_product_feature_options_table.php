<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Features\Entities\FeatureOption;
use Modules\Products\Entities\ProductFeature;
class CreateProductFeatureOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_feature_options', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FeatureOption::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(ProductFeature::class)->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('product_feature_options');
    }
}
