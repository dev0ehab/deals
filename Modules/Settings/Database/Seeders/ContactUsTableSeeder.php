<?php

namespace Modules\Settings\Database\Seeders;

use App\Enums\ContactsTypesEnum;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Settings\Entities\ContactUs;

class ContactUsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Factory::create();
        $types = ContactsTypesEnum::values();
        foreach (range(1, 20) as $index) {
            ContactUs::create([
                'name' => $fake->name,
                'email' => $fake->email,
                'message' => $fake->text,
                'type' => $types[array_rand($types)]
            ]);
        }
    }
}
