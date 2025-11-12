<?php

namespace Modules\Support\Traits;

use Faker\Factory as Faker;

trait AttrLangTrait
{
    public function getAttribute($attr = "name", $fakerMethod = "name" , $wrap = false) : array
    {

        $arr = [];
        foreach (config("locales.languages") as $lang) {
            $faker = Faker::create($lang["faker"]);
            $fakeData = $faker->$fakerMethod ;

            if($wrap){
                $fakeData = "<p>" . $fakeData . "</p>" ;
            }

            $arr[$attr . ":" . $lang["code"]] = $fakeData;
        }
        return $arr ;
    }
}
