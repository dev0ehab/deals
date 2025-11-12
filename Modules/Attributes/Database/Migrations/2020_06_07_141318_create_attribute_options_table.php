<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Attributes\Entities\Attribute;

class CreateAttributeOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignIdFor(Attribute::class)->constrained()->cascadeOnDelete();
            $table->boolean('is_default')->default(false);
            $table->decimal('paper_count_factor', 8, 2)->default(1);
            $table->decimal('price', 8, 2)->nullable();
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
        Schema::dropIfExists('attribute_options');
    }
}
