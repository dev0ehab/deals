<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Accounts\Database\Seeders\UsersTableSeeder;
use Modules\Addresses\Database\Seeders\AddressesDatabaseSeeder;
use Modules\FAQs\Database\Seeders\FAQsTableSeeder;
use Modules\Payments\Database\Seeders\PaymentsTableSeeder;
use Modules\Services\Database\Seeders\ServicesTableSeeder;
use Modules\Settings\Database\Seeders\SettingsDatabaseSeeder;
use Modules\Coupons\Database\Seeders\CouponsDatabaseSeeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LaratrustSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(FAQsTableSeeder::class);
        $this->call(AddressesDatabaseSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(PaymentsTableSeeder::class);
        $this->call(CouponsDatabaseSeeder::class);
        $this->call(SettingsDatabaseSeeder::class);
    }
}
