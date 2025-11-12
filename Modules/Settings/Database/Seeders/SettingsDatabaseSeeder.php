<?php

namespace Modules\Settings\Database\Seeders;

use Illuminate\Database\Seeder;
use Laraeast\LaravelSettings\Facades\Settings;

class SettingsDatabaseSeeder extends Seeder
{
    /**
     * The list of the files keys.
     *
     * @var array
     */
    protected $files = [
        'logo',
        'favicon',
        'loginLogo',
        'loginBackground',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $titles = [
            'theme' => 'dark',
            'email' => 'info@etba3ly.com',
            'phone' => '01005062221',
            'mobile' => '01097099010',
            'whats_app' => '01005062221',
            'fax' => '(+202) 23417149',
            'name:en' => 'etba3ly',
            'name:ar' => 'اطبعلي',
            'description:en' => 'etba3ly',
            'description:ar' => 'اطبعلي',
            'meta_description:en' => 'etba3ly',
            'meta_description:ar' => 'اطبعلي',
            'delivery_fee' => 7,
            'radius' => 3000,

            'facebook' => 'https://www.facebook.com/etba3ly',
            'twitter' => 'https://www.twitter.com/etba3ly',
            'instagram' => 'https://www.instagram.com/etba3ly.eg',
            'youtube' => 'https://www.youtube.com/channel/UCf_AG88Ta8AU8AHE_Mj_fdg',
            'snapchat' => 'https://www.snapchat.com/etba3ly',
            'x' => 'https://www.x.com/etba3ly',
            'telegram' => 'https://www.telegram.com/etba3ly',

            'privacy_content:ar' => '<p>الخصوصية</p>',
            'privacy_content:en' => '<p>privacy</p>',
            'aboutus_content:ar' => '<p>من نحن</p>',
            'aboutus_content:en' => '<p>aboutus</p>',
            'terms_content:ar' => '<p>الشروط و الاحكام</p>',
            'terms_content:en' => '<p>terms</p>',


            'longitude' => '12.23',
            'latitude' => '12.23',

            'phones'=>['01005062221'],

        ];

        foreach ($titles as $key => $value) {
            Settings::set($key, $value);
        }



        // images
        foreach ($this->files as $file) {
            Settings::set($file)->addMediaFromUrl(asset("images/logos/logo.png"))
                ->preservingOriginal()
                ->toMediaCollection($file);
        }
    }
}
