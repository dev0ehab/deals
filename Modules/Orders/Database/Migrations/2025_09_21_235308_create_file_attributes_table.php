<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Attributes\Entities\Attribute;
use Modules\Attributes\Entities\AttributeOption;
use Modules\Orders\Entities\OrderFile;

class CreateFileAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(OrderFile::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Attribute::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(AttributeOption::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('option')->nullable();
            $table->integer('price')->default(0);
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
        Schema::dropIfExists('file_attributes');
    }
}
