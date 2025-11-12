<?php

namespace Modules\Installer\Entities\Utilities;

use Exception;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;

class FinalInstallManager
{
    /**
     * Run final commands.
     *
     * @return string
     */
    public function runFinal()
    {
//        $admin = [
//            'name' => old('admin_name'),
//            'email' => old('admin_email'),
//            'phone' => old('admin_phone'),
//            'password' => old('admin_password'),
//        ];

        $outputLog = new BufferedOutput;

        $this->runCommands($outputLog);
        $this->storageLink($outputLog);

//        Installer::createUser($admin['name'], $admin['email'], $admin['phone'], $admin['password'], app()->getLocale());

        return $outputLog->fetch();
    }

    private static function runCommands($outputLog)
    {
        try {
            Artisan::call('compile:assets', ['--node-package-manager' => 'npm'], $outputLog);
//            Artisan::call('storage:link', [], $outputLog);
        } catch (Exception $e) {
            return static::response($e->getMessage(), $outputLog);
        }

        return $outputLog;
    }

    /**
     * Generate New Application Key.
     *
     * @param BufferedOutput $outputLog
     * @return BufferedOutput|array
     */
    private static function generateKey(BufferedOutput $outputLog)
    {
        try {
            if (config('installer.final.key')) {
                Artisan::call('key:generate', ['--force' => true], $outputLog);
            }
        } catch (Exception $e) {
            return static::response($e->getMessage(), $outputLog);
        }

        return $outputLog;
    }

    /**
     * Publish vendor assets.
     *
     * @param BufferedOutput $outputLog
     * @return BufferedOutput|array
     */
    private static function publishVendorAssets(BufferedOutput $outputLog)
    {
        try {
            if (config('installer.final.publish')) {
                Artisan::call('vendor:publish', ['--all' => true], $outputLog);
            }
        } catch (Exception $e) {
            return static::response($e->getMessage(), $outputLog);
        }

        return $outputLog;
    }

    /**
     * Publish vendor assets.
     *
     * @param BufferedOutput $outputLog
     * @return BufferedOutput|array
     */
    private static function storageLink(BufferedOutput $outputLog)
    {
        try {
            Artisan::call('storage:link', ['--force' => true], $outputLog);
        } catch (Exception $e) {
            return static::response($e->getMessage(), $outputLog);
        }

        return $outputLog;
    }

    /**
     * Return a formatted error messages.
     *
     * @param $message
     * @param BufferedOutput $outputLog
     * @return array
     */
    private static function response($message, BufferedOutput $outputLog)
    {
        return [
            'status' => 'error',
            'message' => $message,
            'dbOutputLog' => $outputLog->fetch(),
        ];
    }
}
