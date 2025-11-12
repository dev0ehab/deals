<?php

namespace Modules\Addresses\Database\Seeders;

use App\Enums\AddressTypesEnum;
use DB;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Modules\Accounts\Entities\User;

class AddressesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::pluck('id')->toArray();

        if (empty($users)) {
            return;
        }

        $addresses = [
            [
                'building_number' => '12',
                'appartement_number' => '4A',
                'floor_number' => '3',
                'street_name' => 'Main Street',
                'landmark' => 'Near Park',
                'area' => 'Downtown',
                'lat' => '30.0444',
                'long' => '31.2357',
                'type' => 'Home',
                'is_default' => true,
                'user_id' => $users[array_rand($users)],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'building_number' => '45',
                'appartement_number' => 'B12',
                'floor_number' => '5',
                'street_name' => 'Elm Street',
                'landmark' => 'Near Mall',
                'area' => 'Suburb',
                'lat' => '30.0500',
                'long' => '31.2400',
                'type' => 'Work',
                'is_default' => false,
                'user_id' => $users[array_rand($users)],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'building_number' => '78',
                'appartement_number' => 'C5',
                'floor_number' => '2',
                'street_name' => 'Oak Avenue',
                'landmark' => 'Near School',
                'area' => 'Residential',
                'lat' => '30.0600',
                'long' => '31.2500',
                'type' => 'Home',
                'is_default' => true,
                'user_id' => $users[array_rand($users)],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'building_number' => '23',
                'appartement_number' => '8D',
                'floor_number' => '6',
                'street_name' => 'Pine Street',
                'landmark' => 'Near Hospital',
                'area' => 'Commercial',
                'lat' => '30.0700',
                'long' => '31.2600',
                'type' => 'Work',
                'is_default' => false,
                'user_id' => $users[array_rand($users)],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'building_number' => '100',
                'appartement_number' => 'A1',
                'floor_number' => '1',
                'street_name' => 'Sunset Boulevard',
                'landmark' => 'Next to Beach',
                'area' => 'Coastal',
                'lat' => '30.0800',
                'long' => '31.2700',
                'type' => 'Vacation',
                'is_default' => false,
                'user_id' => $users[array_rand($users)],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'building_number' => '55',
                'appartement_number' => '3F',
                'floor_number' => '4',
                'street_name' => 'Cedar Road',
                'landmark' => 'Near Bus Stop',
                'area' => 'Urban',
                'lat' => '30.0900',
                'long' => '31.2800',
                'type' => 'Home',
                'is_default' => true,
                'user_id' => $users[array_rand($users)],
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('addresses')->insert($addresses);
    }

}
