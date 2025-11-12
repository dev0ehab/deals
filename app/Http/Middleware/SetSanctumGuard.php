<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Str;

class SetSanctumGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Str::startsWith($request->getRequestUri(), '/api/vendor')) {
            config(['sanctum.guard' => 'vendor']);
        } elseif (Str::startsWith($request->getRequestUri(), '/api/delivery/')) {
            config(['sanctum.guard' => 'delivery']);
        }

        \Artisan::call('optimize:clear');

        return $next($request);
    }
}
