<?php

namespace Modules\Sections\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Sections\Entities\Section;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
        {
            Section::create([
                'name:ar' => 'الاقلام الكتابية',
                'name:en' => 'Writing Supplies',
            ]);

            Section::create([
                'name:ar' => 'الكراسات',
                'name:en' => 'Books',
            ]);
        }
}
