<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Attributes\Database\Seeders\AttributesDatabaseSeeder;
use Modules\Attributes\Database\Seeders\CategorySeeder;
use Modules\Features\Database\Seeders\FeaturesDatabaseSeeder;
use Modules\Sections\Database\Seeders\SectionsTableSeeder;
use Modules\Products\Database\Seeders\ProductsTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->command->call('media-library:clean');

        $this->command->warn('Do not consider seed dummy data while in production mode!');

        $this->call([
            DummyDataSeeder::class,
            CategorySeeder::class,
            AttributesDatabaseSeeder::class,
            // SectionsTableSeeder::class,
            // FeaturesDatabaseSeeder::class,
            ProductsTableSeeder::class, // ProductsTableSeeder is the main seeder that seeds all products with their features
        ]);
    }
}
