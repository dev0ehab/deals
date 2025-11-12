<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ForceHttpsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (\Config::get('app.force_https') === 'true' && $this->app->environment('production')) {
            \URL::forceScheme('https');
        }
    }
}
