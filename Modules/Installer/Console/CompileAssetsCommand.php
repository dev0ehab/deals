<?php

namespace Modules\Installer\Console;

use Exception;
use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class CompileAssetsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compile:assets {--node-package-manager=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs most of the commands needed to make Scaffolding work';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function executeCommand($command): string
    {
        $process = new Process($command);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }

    private function programExists(string $program): bool
    {
        try {
            $this->executeCommand(['which', $program]);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function handle(): void
    {
        $nodePackageManager = $this->option('node-package-manager');

        if (!$nodePackageManager) {
            $nodePackageManager = $this->choice('Which package manager would you like to use for Node.js?', [
                'npm',
                'yarn',
            ]);
        }

        if (!$this->programExists($nodePackageManager)) {
            $this->error('Could not find "' . $nodePackageManager . '", will not be able to compile front-end assets');
        } else {
            $this->info('Installing Node.js packages');
            $this->executeCommand([$nodePackageManager, 'install']);

            $this->info('Compiling front-end assets');
            $this->executeCommand([$nodePackageManager, 'run', 'dev']);
        }

        $this->executeCommand(['composer', 'app:clear']);
//        $this->executeCommand(['composer', 'dump-autoload']);

        $this->info('Done!');
    }
}
