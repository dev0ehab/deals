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

        // 2. Then seed products
        $this->command->info('Seeding products...');
        $this->call(\Modules\Products\Database\Seeders\ProductsTableSeeder::class);

        $this->command->info('All data seeded successfully!');
    }
}
