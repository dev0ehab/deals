<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Modules\Support\Traits\ApiTrait;

class Authenticate extends Middleware
{
    use ApiTrait;
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {

            if ($request->is('api/*')) {
                return route('unauthenticated');
            }
            return route('login');
        }
    }
}
