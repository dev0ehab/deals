<?php

namespace Modules\Accounts\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Accounts\Entities\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admins = Admin::limit(2)->get();
        $bar = $this->command->getOutput()->createProgressBar(
            count($admins)
        );

        $bar->start();

        foreach ($admins as $admin) {
            $admin->attachRole('super_admin');
            $bar->advance();
        }

        $bar->finish();
        $this->command->info("admins roles attached successfully");

    }
}
