<?php

namespace Modules\Products\Database\Seeders;

use Illuminate\Database\Seeder;

class SeedAllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Starting to seed all data...');

        // 1. First seed sections
        $this->command->info('Seeding sections...');
        $this->call(\Modules\Sections\Database\Seeders\SectionsTableSeeder::class);

        // 2. Then seed features and feature options
        $this->command->info('Seeding features and feature options...');
        $this->call(\Modules\Features\Database\Seeders\FeaturesDatabaseSeeder::class);

        // 3. Then seed products with their features
        $this->command->info('Seeding products with features...');
        $this->call(\Modules\Products\Database\Seeders\ProductsTableSeeder::class);

        // 4. Optionally seed additional product features
        $this->command->info('Seeding additional product features...');
        $this->call(\Modules\Products\Database\Seeders\ProductFeaturesTableSeeder::class);

        $this->command->info('All data seeded successfully!');
    }
}
