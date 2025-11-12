<?php

namespace Modules\Products\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Products\Entities\Product;
use Modules\Products\Entities\ProductFeature;
use Modules\Features\Entities\Feature;
use Modules\Features\Entities\FeatureOption;
use Faker\Factory as Faker;

class ProductFeaturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Get all products
        $products = Product::all();
        if ($products->isEmpty()) {
            $this->command->warn('No products found. Please run ProductsTableSeeder first.');
            return;
        }

        // Get all features and their options
        $features = Feature::with('options')->get();
        if ($features->isEmpty()) {
            $this->command->warn('No features found. Please run FeaturesDatabaseSeeder first.');
            return;
        }

        // Create product features for each product
        foreach ($products as $product) {
            // Clear existing features for this product
            $product->features()->delete();

            // Create 2-5 features per product
            $featureCount = $faker->numberBetween(2, 5);

            for ($i = 0; $i < $featureCount; $i++) {
                $featureType = $faker->randomElement(['text', 'image', 'data']);

                $productFeature = ProductFeature::create([
                    'product_id' => $product->id,
                    'text_ar' => 'ميزة ' . $product->translate('ar')->name . ' ' . ($i + 1),
                    'text_en' => 'Feature ' . $product->translate('en')->name . ' ' . ($i + 1),
                    'feature_type' => $featureType,
                    'is_active' => $faker->boolean(90),
                ]);

                // Add content based on feature type
                switch ($featureType) {
                    case 'text':
                        $this->createTextFeature($productFeature, $faker);
                        break;

                    case 'image':
                        $this->createImageFeature($productFeature, $faker);
                        break;

                    case 'data':
                        $this->createDataFeature($productFeature, $features, $faker);
                        break;
                }
            }
        }

        $this->command->info('Product features seeded successfully!');
    }

    /**
     * Create text-based feature
     */
    private function createTextFeature($productFeature, $faker)
    {
        $textTemplates = [
            'ar' => [
                'مقاوم للماء',
                'سهل الاستخدام',
                'عالي الجودة',
                'متوافق مع جميع الأجهزة',
                'ضمان لمدة سنة',
                'تصميم عصري',
                'موفر للطاقة',
                'صديق للبيئة',
                'سريع وسهل',
                'آمن ومضمون'
            ],
            'en' => [
                'Water resistant',
                'Easy to use',
                'High quality',
                'Compatible with all devices',
                'One year warranty',
                'Modern design',
                'Energy efficient',
                'Eco friendly',
                'Fast and easy',
                'Safe and secure'
            ]
        ];

        $randomIndex = $faker->numberBetween(0, count($textTemplates['ar']) - 1);

        $productFeature->update([
            'text_value_ar' => $textTemplates['ar'][$randomIndex],
            'text_value_en' => $textTemplates['en'][$randomIndex],
        ]);
    }

    /**
     * Create image-based feature
     */
    private function createImageFeature($productFeature, $faker)
    {
        // Note: In a real scenario, you would add actual images here
        // For now, we'll just mark it as an image feature
        // The actual image upload would be handled by the ImageFakerTrait
        $this->command->info("Image feature created for product feature ID: {$productFeature->id}");
    }

    /**
     * Create data-based feature (linked to existing features)
     */
    private function createDataFeature($productFeature, $features, $faker)
    {
        // Select a random feature
        $randomFeature = $features->random();

        $productFeature->update([
            'feature_id' => $randomFeature->id,
        ]);

        // Attach 1-3 random options from this feature
        $availableOptions = $randomFeature->options;
        if ($availableOptions->isNotEmpty()) {
            $randomOptions = $availableOptions->random($faker->numberBetween(1, min(3, $availableOptions->count())));
            $productFeature->featureOptions()->attach($randomOptions->pluck('id'));
        }
    }
}
