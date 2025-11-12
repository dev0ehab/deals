<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Attributes\Entities\Category;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements(column: 'id');
            $table->string('name');
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('rank')->nullable();
            $table->timestamps();
        });



        Schema::create('category_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('name');
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
        Schema::dropIfExists('categories');
    }
}
