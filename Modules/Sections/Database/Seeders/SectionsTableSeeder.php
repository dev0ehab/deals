<?php

namespace Modules\Sections\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Sections\Entities\Section;
use Modules\Support\Traits\ImageFakerTrait;

class SectionsTableSeeder extends Seeder
{
    use ImageFakerTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 // make seeder to create 10 sections with random names in arabic and english thats for categories of electronics

        $sections = [
            [
                'name:ar' => 'الهواتف الذكية',
                'name:en' => 'Electronics',
            ],
            [
                'name:ar' => 'الكمبيوترات',
                'name:en' => 'Computers',
            ],
            [
                'name:ar' => 'التلفازات',
                'name:en' => 'Televisions',
            ],
            [
                'name:ar' => 'الثلاجات',
                'name:en' => 'Refrigerators',
            ],
            [
                'name:ar' => 'الغسالات',
                'name:en' => 'Laundry Machines',
            ]
        ];


        foreach ($sections as $section) {
            Section::create($section);
            $this->createImage($section, 'images/sections', 1, 'images');
        }
    }
}
