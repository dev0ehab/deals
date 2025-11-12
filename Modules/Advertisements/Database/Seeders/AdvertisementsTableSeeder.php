<?php

namespace Modules\Advertisements\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Advertisements\Entities\Advertisement;
use Faker\Factory as Faker;
use Modules\Support\Traits\AttrLangTrait;
use Modules\Support\Traits\ImageFakerTrait;

class AdvertisementsTableSeeder extends Seeder
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
        for ($i = 0; $i < 50; $i++) {
            $advertisement = [
                ...$this->getAttribute("title", "name"),
                "active"        => $faker->numberBetween(0, 1),
                "url"        => $faker->url,
            ];

            $ad = Advertisement::create($advertisement);
            $this->createImage($ad);
        }
    }
}
