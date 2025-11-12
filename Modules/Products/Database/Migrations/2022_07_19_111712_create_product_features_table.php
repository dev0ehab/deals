<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Attributes\Entities\Attribute;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\ProductFeature;

class CreateProductFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_features', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete();
            $table->foreignId('feature_id')->nullable()->constrained('features')->onDelete('cascade');
            $table->boolean('is_active')->default(false);
            $table->string('feature_type')->default('text'); // text, image, data
            $table->text('text_ar')->nullable();
            $table->text('text_en')->nullable();
            $table->text('text_value_ar')->nullable();
            $table->text('text_value_en')->nullable();
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
        Schema::dropIfExists('product_features');
    }
}
