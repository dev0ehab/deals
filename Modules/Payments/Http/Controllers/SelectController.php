<?php

namespace Modules\Payments\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Modules\Countries\Http\Filters\SelectFilter;
use Modules\Payments\Entities\Payment;
use Modules\Payments\Transformers\PaymentSelectResource;

class SelectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SelectFilter $filter
     * @return AnonymousResourceCollection
     */
    public function payments(SelectFilter $filter)
    {
        $payments = Payment::active()->filter($filter)->get();

        return PaymentSelectResource::collection($payments);
    }
}
