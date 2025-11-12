<?php

namespace Modules\Attributes\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Products\Entities\Product;
use Modules\Attributes\Entities\Attribute;

class AttributesOptionDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Modules\Attributes\Entities\AttributeOption::create([
            'attribute_id' => Attribute::first()->id,
            'name' => 'red',
        ]);
    }
}
