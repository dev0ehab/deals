<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Attributes\Entities\AttributeOption;

class CreateAttributeOptionTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_option_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignIdFor(AttributeOption::class)->constrained()->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->string('locale')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_option_translations');
    }
}
