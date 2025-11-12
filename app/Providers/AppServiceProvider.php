<?php

namespace App\Providers;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Modules\Accounts\Entities\Observers\EmailVerificationObserver;
use Modules\Accounts\Entities\User;
use Illuminate\Pagination\LengthAwarePaginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (config('app.installed') && config('app.debug')) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }

        if (config('app.env') !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        // If APP_KEY is not set, redirect to /install.php
        if (!\Config::get('app.key') && !app()->runningInConsole() && !file_exists(storage_path('installed'))) {
            // Not defined here yet
            redirect(getSubdirectory() . '/install.php')->send();
        }


        $this->sortByDate();
        $this->paginate();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        User::observe(EmailVerificationObserver::class);
    }


    private function sortByDate()
    {
        Collection::macro('sortByDate', function (string $column, bool $descending = true) {
            /* @var $this Collection */
            return $this->sortBy(function ($datum) use ($column) {
                return strtotime(data_get($datum, $column));
            }, SORT_REGULAR, $descending);
        });
    }


    private function paginate()
    {
        Collection::macro('paginateCollection', function($perPage = 15, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }

}
