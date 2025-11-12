<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Support\Traits\ApiTrait;

class isVendor
{
    use ApiTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (get_class(auth()->user()) == "Modules\Accounts\Entities\Vendor") {
            return $next($request);
        }
        return $this->sendError(__('You do not have permission to access.'), [], '401');
    }
}
