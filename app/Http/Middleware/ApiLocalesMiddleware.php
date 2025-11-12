<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiLocalesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check header request and determine localization
        $local = ($request->hasHeader('Accept-Language')) ? $request->header('Accept-Language') : 'ar';
        // set laravel localization
        app()->setLocale($local);
        // continue request
        return $next($request);
    }
}
