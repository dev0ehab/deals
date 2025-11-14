<?php

namespace Modules\Vendors\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Modules\Vendors\Entities\Vendor;
use Modules\Vendors\Http\Filters\SelectFilter;
use Modules\Accounts\Transformers\SelectResource;
use Modules\Support\Traits\ApiTrait;


class SelectController extends Controller
{
    use  ApiTrait;

    /**
     * Display a listing of the resource.
     *
     * @param SelectFilter $filter
     * @return AnonymousResourceCollection
     */
    public function index(SelectFilter $filter)
    {
        $vendors = Vendor::filter($filter)->whereNull('blocked_at')->get();

        return SelectResource::collection($vendors);
    }

    public function updateFcm(Request $request , Vendor $vendor)
    {
        $vendor->update(["device_token" => $request->token]);
        return $this->sendSuccess(__('Fcm updated successfully.'));
    }
}
