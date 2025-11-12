<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Features\Entities\Feature;

class CreateFeatureOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feature_options', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Feature::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('feature_option_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feature_option_id')->constrained()->cascadeOnDelete()->index('feature_option_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('locale')->index();
            $table->unique(['feature_option_id', 'locale'])->index('feature_option_id_locale');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feature_options');
        Schema::dropIfExists('feature_option_translations');
    }
}
