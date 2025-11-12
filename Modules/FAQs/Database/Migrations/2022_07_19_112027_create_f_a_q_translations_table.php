<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFAQTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('f_a_q_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('f_a_q_id');
            $table->string('question');
            $table->string('answer');
            $table->string('locale')->index();
            $table->unique(['f_a_q_id', 'locale']);
            $table->foreign('f_a_q_id')->references('id')->on('f_a_qs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('f_a_q_translations');
    }
}
