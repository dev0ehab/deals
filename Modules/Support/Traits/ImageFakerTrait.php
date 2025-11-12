<?php

namespace Modules\Support\Traits;

use Faker\Factory as Faker;
use File;


trait ImageFakerTrait
{
    public function createImage($model, $url  = "images/fakers",  $count = 1, $media = "images")
    {
        $faker = Faker::create();

        for ($i = 0; $i < $count; $i++) {

            $files  = File::files(public_path($url));
            $index = $faker->numberBetween(0, count($files) - 1);

            if (isset($files[$index])) {
                $path  = asset($url . "/" . $files[$index]->getFilename());

                $model->addMediaFromUrl($path)->preservingOriginal()->toMediaCollection($media);
            }
        }
    }
}
