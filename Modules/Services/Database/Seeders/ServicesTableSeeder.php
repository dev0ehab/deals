<?php

namespace Modules\Services\Database\Seeders;

use App\Enums\ServicesEnum;
use Illuminate\Database\Seeder;
use Modules\Services\Entities\Service;
use Modules\Support\Traits\ImageFakerTrait;
use Modules\Support\Traits\AttrLangTrait;


class ServicesTableSeeder extends Seeder
{
    use ImageFakerTrait, AttrLangTrait;


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->runFaker($this->services());
    }

    private function runFaker($items, $model = null)
    {
        foreach ($items as $item) {
            $service = Service::create([
                'name:ar' => $item['name:ar'],
                'name:en' => $item['name:en'],
                'price' => 500,
                ...$this->getAttribute('title', 'text'),
                ...$this->getAttribute('description', 'text', false),
            ]);

            $this->createImage($service, 'images/fakers', 1, 'covers');
            $this->createImage($service, 'images/fakers', 5, 'images');
        }
    }

    private function services()
    {
        return [
            [
                'id' => ServicesEnum::Shipping->value,
                'name:ar' => 'طباعة الورق والكتب',
                'name:en' => 'Printing Paper & Books',
                'image' => '',
            ],
            [
                'id' => ServicesEnum::AttachCompany->value,
                'name:ar' => 'الادوات المكتبية',
                'name:en' => 'Office Supplies',
                'image' => '',
            ],
        ];
    }
}
