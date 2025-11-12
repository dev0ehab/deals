<?php

namespace Modules\FAQs\Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Modules\FAQs\Entities\FAQ;

class FAQsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $question = FAQ::create([
                'question:ar' => $faker->sentence(6),
                'question:en' => $faker->sentence(6),
                'question:hi' => $faker->sentence(6),
                'question:ph' => $faker->sentence(6),
                'answer:ar' => $faker->paragraph,
                'answer:en' => $faker->paragraph,
                'answer:hi' => $faker->paragraph,
                'answer:ph' => $faker->paragraph,
            ]);
        }
    }
}
