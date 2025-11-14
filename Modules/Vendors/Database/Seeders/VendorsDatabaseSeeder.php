<?php

namespace Modules\Vendors\Database\Seeders;

use Modules\Support\Traits\ImageFakerTrait;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Hash;
use Modules\Vendors\Entities\Vendor;

class VendorsDatabaseSeeder extends Seeder
{
    use ImageFakerTrait;


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        for ($i = 1; $i < 9; $i++) {

            $data = [
                'name' => "vendor " .  " -- " . $i,
                'username' => "vendor_" .  "_" . $i,
                'phone' => "05430374" .  $i,
                'password' => Hash::make(11445522),
            ];

            $vendor = Vendor::create($data);

            $vendor->setVerified();

            $this->createImage($vendor, "images/avatars", 1, "avatars");
        }
    }
}
