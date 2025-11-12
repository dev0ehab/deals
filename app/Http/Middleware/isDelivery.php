<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Deliveries\Entities\Delivery;
use Modules\Support\Traits\ApiTrait;

class isDelivery
{
    use ApiTrait;

    public function handle(Request $request, Closure $next)
    {
        if (get_class(auth()->user()) == Delivery::class) {
            return $next($request);
        }
        return $this->sendError(__('This Request is only for Deliveries.'));
    }
}
