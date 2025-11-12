<?php

namespace Modules\Accounts\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Accounts\Entities\User;
use Faker\Factory  as Faker;
use Hash;
use Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = \Modules\Accounts\Entities\Admin::firstOrCreate([
            'email' => 'admin@demo.com',
        ], \Modules\Accounts\Entities\Admin::factory()->raw([
            'name' => 'Admin',
            'email' => 'admin@demo.com',
            'phone' => '987654123',
        ]));

        $admin->attachRole('super_admin');

        $this->seedUsers();
    }

    private function seedUsers($count = 1)
    {
        $faker = Faker::create();
        $data = [
            'name' => 'ehab',
            'l_name' => 'barakat',
            'email' => "ehab@gmail.com",
            'phone' => '0543037411',
            'phone_verified_at' => now(),
            'password' => Hash::make(11445522),
            'remember_token' => Str::random(10),
        ];

        for ($i = 0; $i < $count; $i++) {
            $user = User::create($data);
            $data['name'] = 'user ' . $i;
            $data['email'] = $faker->unique()->safeEmail;
            $data['phone'] = '05430374' . $i . '1';
        }
    }
}
