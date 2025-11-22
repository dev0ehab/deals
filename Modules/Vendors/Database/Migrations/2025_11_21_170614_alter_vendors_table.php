<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('store_name')->nullable();
            $table->text('store_description_ar')->nullable();
            $table->text('store_description_en')->nullable();
            $table->boolean('is_accepted')->nullable();
            $table->text('rejection_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn('store_name');
            $table->dropColumn('store_description_ar');
            $table->dropColumn('store_description_en');
            $table->dropColumn('is_accepted');
            $table->dropColumn('rejection_reason');
        });
    }
}
