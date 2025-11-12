<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isWorker
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
        if (get_class(auth()->user()) == "Modules\Workers\Entities\Worker") {
            return $next($request);
        }
        return response()->json('You do not have permission to access this route.');
    }
}
