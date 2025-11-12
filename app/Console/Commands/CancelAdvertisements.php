<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Advertisements\Entities\Advertisement;

class CancelAdvertisements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cancel:advertisements';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'cancel expire advertisements';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $advertisements = Advertisement::defined()->expire()->active();

        if ($advertisements->count() > 0) {
            // update order
            $advertisements->update([
                'active' => 0,
            ]);

            $this->info('expired advertisements are cancelled.');
        }

        return 1;
    }
}
