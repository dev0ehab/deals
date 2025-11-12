<?php

namespace Modules\Services\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use Modules\Services\Entities\Service;
use Modules\Services\Http\Filters\ServiceFilter;
use Modules\Services\Transformers\ServiceBriefResource;
use Modules\Services\Transformers\ServiceResource;
use Modules\Support\Traits\ApiTrait;

class ServicesController extends Controller
{
    use ApiTrait;

    private $filter;

    /**
     * ServiceFilter constructor.
     */
    public function __construct(ServiceFilter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Display a listing of the Advertisements.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data =  ServiceBriefResource::collection(Service::filter($this->filter)->orderBy("rank")->get())->response()->getData(true);
        return $this->sendResponse($data, 'success');
    }


    public function show(Service $service)
    {
        return $this->sendResponse(new ServiceResource($service), 'success');
    }
}
