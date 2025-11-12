<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class DropTableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'table:drop {table_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop a specific table if it exists and delete it from migration table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $table_name = $this->argument('table_name');

        if (Schema::hasTable($table_name)) {
            Schema::dropIfExists($table_name);
            $this->info("Table '{$table_name}' has been dropped.");
        } else {
            $this->warn("Table '{$table_name}' does not exist.");
        }

        // Attempt to remove from migrations table
        $deleted = \DB::table('migrations')
            ->where('migration', 'like', "%{$table_name}%")
            ->delete();

        if ($deleted) {
            $this->info("Migration record(s) related to '{$table_name}' deleted from migrations table.");
        } else {
            $this->warn("No migration records found related to '{$table_name}'.");
        }

        return 0;
    }
}
