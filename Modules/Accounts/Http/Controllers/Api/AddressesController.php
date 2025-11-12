<?php

namespace Modules\Accounts\Http\Controllers\Api;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Accounts\Entities\User;
use Modules\Accounts\Http\Requests\Api\AddressesApiRequest;
use Modules\Addresses\Entities\Address;
use Modules\Addresses\Transformers\AddressesResource;
use Modules\Support\Traits\ApiTrait;

class AddressesController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, ApiTrait;

    public function __construct()
    {
        $this->middleware('isUser');
    }

    public function index()
    {
        $addresses = auth()->user()->addresses;
        $data = AddressesResource::collection($addresses);
        return $this->sendResponse($data, __('Data Found'));
    }

    public function show($id)
    {
        $address = Address::find($id);
        if ($address) {
            $data = new AddressesResource($address);
            return $this->sendResponse($data, __('Data Found'));
        }
        return $this->sendError(__("Not Found"));
    }

    public function store(AddressesApiRequest $request)
    {
        $user = User::find(auth()->user()->id);
        if ($user) {
            $address = $user->addresses()->create($request->all());
            $data = $address->getResource();
            return $this->sendResponse($data, __("addresses::addresses.messages.created"));
        }
    }


    public function update(AddressesApiRequest $request, $id)
    {
        $address = Address::find($id);
        if ($address) {
            $address->update($request->all());
            $data = $address->getResource();
            return $this->sendResponse($data, __("addresses::addresses.messages.updated"));
        }
        return $this->sendError(__("Not Found"));
    }

    public function destroy($id)
    {
        $address = Address::find($id);
        if ($address) {

            $address->delete();
            return $this->sendSuccess(__("addresses::addresses.messages.deleted"));
        }
        return $this->sendError(__("Not Found"));
    }

    public function check(Request $request)
    {
        deliveryPrice($request->lat , $request->long);
        return $this->sendSuccess(__("Data Found"));
    }
}
