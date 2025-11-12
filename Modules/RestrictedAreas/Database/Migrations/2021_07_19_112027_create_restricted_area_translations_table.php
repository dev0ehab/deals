<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestrictedAreaTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restricted_area_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('restricted_area_id');
            $table->string('name');
            $table->string('locale')->index();
            $table->unique(['restricted_area_id', 'locale']);
            $table->foreign('restricted_area_id')->references('id')->on('restricted_areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restricted_area_translations');
    }
}
