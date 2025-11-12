<?php

namespace App\Http\Middleware;

use App\Enums\DeliveryStatusEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Deliveries\Entities\Delivery;
use Modules\Support\Traits\ApiTrait;

class DeliveryStillRegister
{
    use ApiTrait;

    public function handle(Request $request, Closure $next)
    {
        if (user() && get_class(user()) == Delivery::class) {
            Auth::login(user());
            return $next($request);
        }
        return $this->sendError('unauthenticated');

    }
}
