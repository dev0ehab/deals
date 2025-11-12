<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RolesRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roles:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh roles and permissions tables';

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
        $this->info('The command will take some time, please wait ..');

        \Artisan::call('db:seed --class=LaratrustSeeder');

        $this->info('Refreshing is completed.');

        return 1;
    }
}
