<?php

namespace Modules\Installer\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfNotInstalledMiddleware
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
        if (config('app.installed', false) === true) {
            return $next($request);
        }

        // Already in the installation wizard
        if ($request->is('installer')) {
            return $next($request);
        }

        // Not installed, redirect to installation wizard
        return redirect()->route('installer.welcome');
    }
}
