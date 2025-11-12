<?php

namespace Modules\Addresses\Http\Controllers\Api;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Addresses\Entities\Address;
use Modules\Addresses\Http\Requests\AddressRequest;
use Modules\Addresses\Repositories\AddressRepository;
use Modules\Addresses\Transformers\AddressesResource;
use Modules\Support\Traits\ApiTrait;

class AddressController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, ApiTrait;

    /**
     * The repository instance.
     *
     * @var AddressRepository
     */
    private AddressRepository $repository;

    /**
     * AddressController constructor.
     *
     * @param AddressRepository $repository
     */
    public function __construct(AddressRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the user addresses.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $addresses = $this->repository->all();
        $data = AddressesResource::collection($addresses)->response()->getData(true);
        return $this->sendResponse($data, 'success');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddressRequest $request
     * @return JsonResponse
     */
    public function store(AddressRequest $request): JsonResponse
    {
        $address = $this->repository->create(auth()->user(), $request->validated());
        return $this->sendResponse(new AddressesResource($address), 'success');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Address $address
     * @return JsonResponse
     */
    public function show(Address $address): JsonResponse
    {
        $data = new AddressesResource($address);
        return $this->sendResponse($data, 'success');
    }

    /**
     * update address.
     *
     * @param AddressRequest $request
     * @param Address $address
     * @return JsonResponse
     */
    public function update(AddressRequest $request, Address $address)
    {
        $this->repository->update($address, $request->all());
        return $this->sendResponse(new AddressesResource($address), 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Address $address
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Address $address)
    {
        $this->repository->delete($address);

        $addresses = $this->repository->all();

        $data = AddressesResource::collection($addresses)->response()->getData(true);
        return $this->sendResponse($data, 'successfully deleted');
    }

    /**
     * update address.
     *
     * @param Request $request
     * @param Address $address
     * @return JsonResponse
     */
    public function default(Request $request, Address $address)
    {
        deliveryPrice($address->lat, $address->long);

        $this->repository->update($address, $request->all());

        $addresses = $this->repository->all();

        $data = AddressesResource::collection($addresses)->response()->getData(true);

        return $this->sendResponse($data, 'success');
    }
}
