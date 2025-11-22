<?php

namespace Modules\Products\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Support\Traits\AttrLangTrait;
use Modules\Support\Traits\ImageFakerTrait;
use Modules\Products\Entities\Product;
use Modules\Sections\Entities\Section;
use Faker\Factory as Faker;

class ProductsTableSeeder extends Seeder
{
    use ImageFakerTrait, AttrLangTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Get existing sections or create some
        $sections = Section::all();
        if ($sections->isEmpty()) {
            $this->command->info('Creating sections...');
            $sections = collect([
                Section::create([
                    'name:ar' => 'الاقلام الكتابية',
                    'name:en' => 'Writing Supplies',
                ]),
                Section::create([
                    'name:ar' => 'الكراسات',
                    'name:en' => 'Notebooks',
                ]),
                Section::create([
                    'name:ar' => 'الادوات المكتبية',
                    'name:en' => 'Office Supplies',
                ])
            ]);
        }

        // Create 20 products
        $this->command->info('Creating products...');
        for ($i = 1; $i <= 20; $i++) {
            $product = Product::create([
                'name:ar' => 'منتج ' . $i,
                'name:en' => 'Product ' . $i,
                'description:ar' => 'وصف المنتج ' . $i . ' باللغة العربية',
                'description:en' => 'Product ' . $i . ' description in English',
                'price' => $faker->randomFloat(2, 10, 500),
                'stock' => $faker->numberBetween(0, 100),
                'section_id' => $sections->random()->id,
                'is_active' => $faker->boolean(80),                           // 80% chance of being active
            ]);

            // Add cover image
            $this->createImage($product, "images/fakers", 1, 'covers');

            // Add multiple images
            $imageCount = $faker->numberBetween(1, 5);
            for ($j = 0; $j < $imageCount; $j++) {
                    $this->createImage($product, "images/fakers", 1, 'images');
            }
        }

        $this->command->info('Products seeded successfully!');
    }
}
