<?php

namespace App\Http\Middleware;

use App\Enums\DeliveryStatusEnum;
use Closure;
use Illuminate\Http\Request;
use Modules\Support\Traits\ApiTrait;

class DeliveryStatus
{
    use ApiTrait;

    public function handle(Request $request, Closure $next, $status)
    {
        if (auth()->user()->status == $status) {
            return $next($request);
        }
        $message = trans("deliveries::validations.the delivery status should be :status", ["status" => DeliveryStatusEnum::translatedName($status)]);
        return $this->sendError($message);

    }
}
