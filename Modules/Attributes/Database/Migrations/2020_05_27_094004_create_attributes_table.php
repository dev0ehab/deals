<?php

use App\Enums\AttributePricingEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Attributes\Entities\Category;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->boolean('is_active')->default(true);
            $table->string('pricing_type')->default(AttributePricingEnum::PAPER_PRICE->value);
            $table->unsignedBigInteger('rank')->nullable();
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
        Schema::dropIfExists('attributes');
    }
}
