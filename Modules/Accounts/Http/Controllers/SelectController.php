<?php

namespace Modules\Accounts\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Modules\Accounts\Entities\User;
use Modules\Accounts\Http\Filters\SelectFilter;
use Modules\Accounts\Transformers\SelectResource;
use Modules\Support\Traits\ApiTrait;
use Modules\Vendors\Entities\Vendor;
use Modules\Vendors\Transformers\VendorSelectResource;

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
        $users = User::filter($filter)->whereNull('type')->whereNull('blocked_at')->where('id', '!=', 1)->get();

        return SelectResource::collection($users);
    }

    public function updateFcm(Request $request , User $user)
    {
        $user->update(["device_token" => $request->token]);
        return $this->sendSuccess(__('Fcm updated successfully.'));
    }
}
