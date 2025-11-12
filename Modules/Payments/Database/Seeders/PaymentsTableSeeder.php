<?php

namespace Modules\Payments\Database\Seeders;

use App\Enums\PaymentsEnum;
use Illuminate\Database\Seeder;
use Modules\Payments\Entities\Payment;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bar = $this->command->getOutput()->createProgressBar(
            count(PaymentsEnum::seeder())
        );

        $bar->start();

        foreach (PaymentsEnum::seeder() as $payment) {
            Payment::create($payment);

            $bar->advance();
        }

        $bar->finish();
        $this->command->info("\n Payments seeded successfully");
    }

}
