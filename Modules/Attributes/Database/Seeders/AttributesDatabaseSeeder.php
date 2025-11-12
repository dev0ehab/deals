<?php

namespace Modules\Attributes\Database\Seeders;

use App\Enums\AttributePricingEnum;
use Illuminate\Database\Seeder;
use Modules\Attributes\Entities\Attribute;
use Modules\Attributes\Entities\BulkDiscount;
use Modules\Attributes\Entities\PricingMatrix;
use Modules\Support\Traits\AttrLangTrait;
use Modules\Support\Traits\ImageFakerTrait;

class AttributesDatabaseSeeder extends Seeder
{
    use AttrLangTrait , ImageFakerTrait;
      /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data() as $data) {
            $attribute = Attribute::create(collect($data)->except('options')->toArray());
            foreach ($data["options"] as $option) {
                $attributeOption = $attribute->options()->create(collect($option)->except('image', 'icon')->toArray());

                if(isset($option['image'])){

                    $attributeOption->addMediaFromUrl(asset('images/attributes/'.$option['image']))->toMediaCollection('images');
                }
                if(isset($option['icon'])){
                    // $this->createImage($attributeOption, 'images/fakers', 1, 'icons');
                    $attributeOption->addMediaFromUrl(asset('images/attributes/'.$option['icon']))->toMediaCollection('icons');
                }

            }
        }

        $this->pricingMatrix();
        $this->bulkDiscountPercent();

    }

    public function data(): array
    {
        return [

            [
                'title:ar' => 'نوع الطباعة',
                'title:en' => 'Print Type',
                ...$this->getAttribute('description', 'text' , true),
                'rank'         => 1,
                'category_id'  => 1,
                'is_active'    => true,
                "pricing_type" => AttributePricingEnum::PAPER_PRICE->value,
                "type"         => "select",
                "options"      => [
                    [
                        "name:ar" => "حبر",
                        "name:en" => "Ink",
                        "icon"    => "ink.svg",
                        "is_default" => true,
                    ],
                    [
                        "name:ar" => "ليزر",
                        "name:en" => "Laser",
                        "icon"    => "laser.svg",
                    ],
                ],
            ],


            [
                'title:ar' => 'خيارات الطباعة',
                'title:en' => 'Print Options',
                ...$this->getAttribute('description', 'text' , true),
                'rank'         => 2,
                'category_id'  => 1,
                'is_active'    => true,
                "pricing_type" => AttributePricingEnum::PAPER_PRICE->value,
                "type"         => "select",
                "options"      => [
                    [
                        "name:ar"            => "وجه واحد",
                        "name:en"            => "One Side",
                        "paper_count_factor" => 1,
                        "icon"               => "one-side-paper.svg",
                        "is_default"         => true,
                    ],
                    [
                        "name:ar"            => "وجهين",
                        "name:en"            => "Two Sides",
                        "paper_count_factor" => 2,
                        "icon"               => "two-side-paper.svg",
                    ],
                ],
            ],



            [
                'title:ar' => 'لون الطباعة',
                'title:en' => 'Print Color',
                ...$this->getAttribute('description', 'text' , true),
                'rank'         => 3,
                'category_id'  => 1,
                'is_active'    => true,
                "pricing_type" => AttributePricingEnum::PAPER_PRICE->value,
                "type"         => "select",
                "options"      => [
                    [
                        "name:ar" => "ابيض و اسود",
                        "name:en" => "White and Black",
                        "icon"    => "black.png",
                        "is_default" => true,
                    ],
                    [
                        "name:ar" => "الوان متعددة",
                        "name:en" => "Multiple Colors",
                        "icon"    => "colored.png",
                    ],
                ],
            ],


            [
                'title:ar' => 'مقاس الورق',
                'title:en' => 'Paper Size',
                ...$this->getAttribute('description', 'text' , true),
                'rank'         => 4,
                'category_id'  => 2,
                'is_active'    => true,
                "pricing_type" => AttributePricingEnum::PAPER_PRICE->value,
                "type"         => "select",
                "options"      => [
                    [
                        "name:ar" => "70 جرام",
                        "name:en" => "70 Grams",
                        "is_default" => true,
                    ],
                    [
                        "name:ar" => "80 جرام",
                        "name:en" => "80 Grams",
                    ]
                ],
            ],



            [
                'title:ar' => 'نوع الورق',
                'title:en' => 'Paper Type',
                ...$this->getAttribute('description', 'text' , true),
                'rank'         => 5,
                'category_id'  => 2,
                'is_active'    => true,
                "pricing_type" => AttributePricingEnum::PAPER_PRICE->value,
                "type"         => "select",
                "options"      => [
                    [
                        "name:ar" => "A3",
                        "name:en" => "A3",
                        "icon"    => "a3.svg",
                        "is_default" => true,
                    ],
                    [
                        "name:ar" => "A4",
                        "name:en" => "A4",
                        "icon"    => "a4.svg",
                    ],
                    [
                        "name:ar" => "A5",
                        "name:en" => "A5",
                        "icon"    => "a5.svg",
                    ],
                    [
                        "name:ar" => "B5",
                        "name:en" => "B5",
                        "icon"    => "b5.svg",
                    ],
                ],
            ],



            [
                'title:ar' => 'خيارات التجليد',
                'title:en' => 'Binding Options',
                ...$this->getAttribute('description', 'text' , true),
                'rank'         => 6,
                'category_id'  => 2,
                'is_active'    => true,
                "pricing_type" => AttributePricingEnum::TOTAL_PRICE->value,
                "type"         => "select",
                "options"      => [
                    [
                        "name:ar" => "بدون تجليد",
                        "name:en" => "No Binding",
                        "price"   => 0,
                        "is_default" => true,
                    ],
                    [
                        "name:ar" => "تدبيس",
                        "name:en" => "Stitching",
                        "price"   => 10,
                        "icon"    => "stapler.svg",
                    ],
                    [
                        "name:ar" => "ملف شفاف",
                        "price"   => 15,
                        "name:en" => "Transparent File",
                    ],
                    [
                        "name:ar" => "تكعيب",
                        "name:en" => "Boxing",
                        "price"   => 20,
                    ],

                ],
            ],



            [
                'title:ar' => 'الاتجاه',
                'title:en' => 'Direction',
                ...$this->getAttribute('description', 'text' , true),
                'rank'         => 7,
                'category_id'  => 3,
                'is_active'    => true,
                "pricing_type" => AttributePricingEnum::NO_PRICE->value,
                "type"         => "select",
                "options"      => [
                    [
                        "name:ar" => "أفقي",
                        "name:en" => "Horizontal",
                        "icon"   => "one-side-paper-horizontal.svg",
                        "is_default" => true,
                    ],
                    [
                        "name:ar" => "عمودي",
                        "name:en" => "Vertical",
                        "icon"   => "one-side-paper.svg",
                    ],
                ],
            ],

            [
                'title:ar' => 'عدد الصفحات في الورقة',
                'title:en' => 'Pages per Sheet',
                ...$this->getAttribute('description', 'text' , true),
                'rank'         => 8,
                'category_id'  => 3,
                'is_active'    => true,
                "pricing_type" => AttributePricingEnum::NO_PRICE->value,
                "type"         => "select",
                "options"      => [
                    [
                        "name:ar"            => "1",
                        "name:en"            => "1",
                        "paper_count_factor" => 1,
                        "icon"               => "one-side-paper.svg",
                    ],
                    [
                        "name:ar"            => "2",
                        "name:en"            => "2",
                        "paper_count_factor" => 2,
                        "icon"               => "two-paper-horizontal.svg",
                    ],
                    [
                        "name:ar"            => "2",
                        "name:en"            => "2",
                        "paper_count_factor" => 2,
                        "icon"               => "two-pages-per-paper.svg",
                    ],
                    [
                        "name:ar"            => "4",
                        "name:en"            => "4",
                        "paper_count_factor" => 4,
                        "icon"               => "four-pages-per-paper.svg",
                    ],
                ],
            ],

            [
                'title:ar' => 'طباعة صفحات محدده',
                'title:en' => 'Print Specific Pages',
                ...$this->getAttribute('description', 'text' , true),
                'rank'         => 9,
                'category_id'  => 3,
                'is_active'    => true,
                "pricing_type" => AttributePricingEnum::NO_PRICE->value,
                "type"         => "text",
                "options"      => [],
            ],

        ];
    }

    public function pricingMatrix()
    {
        $attributes = Attribute::where('pricing_type', AttributePricingEnum::PAPER_PRICE->value)->with('options')->get();

        $matrix = generateAttributeMatrix($attributes);

        foreach ($matrix as $index => $key) {
            PricingMatrix::create([
                'key'   => $key,
                'value' => $index + 1.35,
            ]);
        }
    }


    public function bulkDiscountPercent()
    {
        BulkDiscount::create([
            'from' => 1,
            'to' => 10,
            'percent' => 5,
        ]);

        BulkDiscount::create([
            'from' => 11,
            'to' => 20,
            'percent' => 7,
        ]);

        BulkDiscount::create([
            'from' => 21,
            'to' => 30,
            'percent' => 9,
        ]);

        BulkDiscount::create([
            'from' => 31,
            'to' => 40,
            'percent' => 11,
        ]);

        BulkDiscount::create([
            'from' => 41,
            'to' => 50,
            'percent' => 13,
        ]);

        BulkDiscount::create([
            'from' => 51,
            'to' => 60,
            'percent' => 15,
        ]);
    }

}
