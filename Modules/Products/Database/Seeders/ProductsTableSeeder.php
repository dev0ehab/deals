<?php

namespace Modules\Products\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Support\Traits\AttrLangTrait;
use Modules\Support\Traits\ImageFakerTrait;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\ProductFeature;
use Modules\Sections\Entities\Section;
use Modules\Features\Entities\Feature;
use Modules\Features\Entities\FeatureOption;
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

        // Get existing features or create some
        $features = Feature::all();
        if ($features->isEmpty()) {
            $this->command->info('Creating features...');
            $features = collect([
                Feature::create([
                    'name:ar' => 'اللون',
                    'name:en' => 'Color',
                ]),
                Feature::create([
                    'name:ar' => 'الحجم',
                    'name:en' => 'Size',
                ]),
                Feature::create([
                    'name:ar' => 'المادة',
                    'name:en' => 'Material',
                ]),
                Feature::create([
                    'name:ar' => 'النوع',
                    'name:en' => 'Type',
                ])
            ]);
        }

        // Create feature options for each feature
        $featureOptions = collect();
        foreach ($features as $feature) {
            $options = collect([
                FeatureOption::create([
                    'feature_id' => $feature->id,
                    'name:ar' => 'خيار ' . $feature->translate('ar')->name . ' 1',
                    'name:en' => 'Option ' . $feature->translate('en')->name . ' 1',
                ]),
                FeatureOption::create([
                    'feature_id' => $feature->id,
                    'name:ar' => 'خيار ' . $feature->translate('ar')->name . ' 2',
                    'name:en' => 'Option ' . $feature->translate('en')->name . ' 2',
                ]),
                FeatureOption::create([
                    'feature_id' => $feature->id,
                    'name:ar' => 'خيار ' . $feature->translate('ar')->name . ' 3',
                    'name:en' => 'Option ' . $feature->translate('en')->name . ' 3',
                ])
            ]);
            $featureOptions = $featureOptions->merge($options);
        }

        // Create 20 products
        $this->command->info('Creating products with features...');
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

            // Create product features with different types
            $this->createProductFeatures($product, $features, $featureOptions, $faker);
        }

        $this->command->info('Products and features seeded successfully!');
    }

    /**
     * Create product features with different types
     */
    private function createProductFeatures($product, $features, $featureOptions, $faker)
    {
        // Create 3-6 features per product
        $featureCount = $faker->numberBetween(3, 6);

        for ($i = 0; $i < $featureCount; $i++) {
            $featureType = $faker->randomElement(['text', 'image', 'data']);

            $productFeature = ProductFeature::create([
                'product_id' => $product->id,
                'text_ar' => 'ميزة المنتج ' . $i,
                'text_en' => 'Product Feature ' . $i,
                'feature_type' => $featureType,
                'is_active' => $faker->boolean(90),
            ]);

            // Add content based on feature type
            switch ($featureType) {
                case 'text':
                    $productFeature->update([
                        'text_value_ar' => 'قيمة نصية باللغة العربية للميزة ' . $i,
                        'text_value_en' => 'Text value in English for feature ' . $i,
                    ]);
                    break;

                case 'image':
                    // Add image to the feature
                        $this->createImage($productFeature, "images/fakers", 1, 'images');
                    break;

                case 'data':
                    // Link to existing feature and its options
                    $randomFeature = $features->random();
                    $productFeature->update([
                        'feature_id' => $randomFeature->id,
                    ]);

                    // Attach some feature options
                    $randomOptions = $featureOptions
                        ->where('feature_id', $randomFeature->id)
                        ->random($faker->numberBetween(1, 3));

                    $productFeature->featureOptions()->attach($randomOptions->pluck('id'));
                    break;
            }
        }
    }
}
