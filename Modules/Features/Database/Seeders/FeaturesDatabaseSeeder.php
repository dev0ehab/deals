<?php

namespace Modules\Features\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Features\Entities\Feature;
use Modules\Features\Entities\FeatureOption;

class FeaturesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create specific features with meaningful names
        $featuresData = [
            [
                'name:ar' => 'اللون',
                'name:en' => 'Color',
                'options' => [
                    ['name:ar' => 'أحمر', 'name:en' => 'Red'],
                    ['name:ar' => 'أزرق', 'name:en' => 'Blue'],
                    ['name:ar' => 'أخضر', 'name:en' => 'Green'],
                    ['name:ar' => 'أسود', 'name:en' => 'Black'],
                    ['name:ar' => 'أبيض', 'name:en' => 'White'],
                ]
            ],
            [
                'name:ar' => 'الحجم',
                'name:en' => 'Size',
                'options' => [
                    ['name:ar' => 'صغير', 'name:en' => 'Small'],
                    ['name:ar' => 'متوسط', 'name:en' => 'Medium'],
                    ['name:ar' => 'كبير', 'name:en' => 'Large'],
                    ['name:ar' => 'كبير جداً', 'name:en' => 'Extra Large'],
                ]
            ],
            [
                'name:ar' => 'المادة',
                'name:en' => 'Material',
                'options' => [
                    ['name:ar' => 'بلاستيك', 'name:en' => 'Plastic'],
                    ['name:ar' => 'معدن', 'name:en' => 'Metal'],
                    ['name:ar' => 'خشب', 'name:en' => 'Wood'],
                    ['name:ar' => 'ورق', 'name:en' => 'Paper'],
                ]
            ],
            [
                'name:ar' => 'النوع',
                'name:en' => 'Type',
                'options' => [
                    ['name:ar' => 'عادي', 'name:en' => 'Regular'],
                    ['name:ar' => 'مميز', 'name:en' => 'Premium'],
                    ['name:ar' => 'اقتصادي', 'name:en' => 'Economy'],
                ]
            ],
            [
                'name:ar' => 'العلامة التجارية',
                'name:en' => 'Brand',
                'options' => [
                    ['name:ar' => 'ماركة أ', 'name:en' => 'Brand A'],
                    ['name:ar' => 'ماركة ب', 'name:en' => 'Brand B'],
                    ['name:ar' => 'ماركة ج', 'name:en' => 'Brand C'],
                ]
            ],
            [
                'name:ar' => 'الوزن',
                'name:en' => 'Weight',
                'options' => [
                    ['name:ar' => 'خفيف', 'name:en' => 'Light'],
                    ['name:ar' => 'متوسط', 'name:en' => 'Medium'],
                    ['name:ar' => 'ثقيل', 'name:en' => 'Heavy'],
                ]
            ],
            [
                'name:ar' => 'الاستخدام',
                'name:en' => 'Usage',
                'options' => [
                    ['name:ar' => 'منزلي', 'name:en' => 'Home'],
                    ['name:ar' => 'مكتبي', 'name:en' => 'Office'],
                    ['name:ar' => 'مدرسي', 'name:en' => 'School'],
                ]
            ],
            [
                'name:ar' => 'العمر المناسب',
                'name:en' => 'Age Group',
                'options' => [
                    ['name:ar' => 'أطفال', 'name:en' => 'Children'],
                    ['name:ar' => 'مراهقين', 'name:en' => 'Teenagers'],
                    ['name:ar' => 'بالغين', 'name:en' => 'Adults'],
                ]
            ]
        ];

        foreach ($featuresData as $featureData) {
            $feature = Feature::create([
                'name:ar' => $featureData['name:ar'],
                'name:en' => $featureData['name:en'],
            ]);

            // Create options for this feature
            foreach ($featureData['options'] as $optionData) {
                FeatureOption::create([
                    'feature_id' => $feature->id,
                    'name:ar' => $optionData['name:ar'],
                    'name:en' => $optionData['name:en'],
                ]);
            }
        }
    }
}
