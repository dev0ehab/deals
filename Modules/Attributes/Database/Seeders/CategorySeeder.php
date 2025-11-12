<?php

namespace Modules\Attributes\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Attributes\Entities\Category;
use Modules\Support\Traits\ImageFakerTrait;

class CategorySeeder extends Seeder
{
    use ImageFakerTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $categories = [
            [
                'name:ar' => 'اعدادات الطباعة الاساسية',
                'name:en' => 'Basic Print Settings',
                'is_active' => true,
                'rank' => 1,
                'icon' => 'basic_setting.png',
            ],
            [
                'name:ar' => 'اعدادات الورق و التجليد',
                'name:en' => 'Paper and Binding Settings',
                'is_active' => true,
                'rank' => 2,
                'icon' => 'paper_setting.png',
            ],
            [
                'name:ar' => 'اعدادات الطباعة المتقدمة',
                'name:en' => 'Advanced Print Settings',
                'is_active' => true,
                'rank' => 3,
                'icon' => 'advanced_setting.png',
            ]
        ];

        foreach ($categories as $category) {
            $category_model = Category::create(collect($category)->except('icon')->toArray());

            if(isset($category['icon'])){
                $category_model->addMediaFromUrl(asset('images/attributes/'.$category['icon']))->toMediaCollection('icons');
            }
        }
    }
}
