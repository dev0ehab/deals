<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ModuleCloneCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:clone {module} {clone}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $moduleName = Str::of($this->argument('module'))->plural()->studly();

        $modulePath = module_path($moduleName);

        $cloneName = Str::of($this->argument('clone'))->plural()->studly();

        $cloneContents = [];

        foreach ($this->getDirContents($modulePath) as $key => $item) {
            $cloneContents[$key]['dir'] = $item['dir'];
            $cloneContents[$key]['file'] = $item['file'];
            $cloneContents[$key]['content'] = $item['content'];

            $this->replace($moduleName, $cloneName, $cloneContents[$key]['dir']);
            $this->replace($moduleName, $cloneName, $cloneContents[$key]['file']);
            $this->replace($moduleName, $cloneName, $cloneContents[$key]['content']);
        }

        foreach ($cloneContents as $cloneContent) {
            if (!is_dir($cloneContent['dir'])) {
                if (!mkdir($concurrentDirectory = $cloneContent['dir'], 0755, true) && !is_dir($concurrentDirectory)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
                }
            }
            if ($cloneContent['file']) {
                file_put_contents($cloneContent['file'], $cloneContent['content']);
            }
        }

        $this->info("Module {$cloneName} has been created successfully.");
    }

    /**
     * @param $dir
     * @param array $results
     * @return array
     */
    protected function getDirContents($dir, &$results = [])
    {
        $files = glob("$dir");

        foreach ($files as $key => $file) {
            if (!is_dir($file)) {
                $results[] = [
                    'dir' => dirname($file),
                    'file' => $file,
                    'content' => file_get_contents($file),
                ];
            } else {
                $this->getDirContents($file . '/*', $results);
                $results[] = [
                    'dir' => $file,
                    'file' => null,
                    'content' => null,
                ];
            }
        }

        return $results;
    }

    /**
     * @param $from
     * @param $to
     * @param $str
     */
    protected function replace($from, $to, &$str)
    {
        $str = Str::of($str)->replace(
            Str::of($from)->studly()->plural(),
            Str::of($to)->studly()->plural()
        );

        $str = Str::of($str)->replace(
            Str::of($from)->studly()->singular(),
            Str::of($to)->studly()->singular()
        );

        $str = Str::of($str)->replace(
            Str::of($from)->camel()->plural()->prepend('$'),
            Str::of($to)->snake()->plural()->prepend('$')
        );

        $str = Str::of($str)->replace(
            Str::of($from)->camel()->singular()->prepend('$'),
            Str::of($to)->snake()->singular()->prepend('$')
        );

        $str = Str::of($str)->replace(
            Str::of($from)->snake()->lower()->plural(),
            Str::of($to)->snake()->lower()->plural()
        );

        $str = Str::of($str)->replace(
            Str::of($from)->snake()->lower()->singular(),
            Str::of($to)->snake()->lower()->singular()
        );

        $str = (string)$str;
    }
}
