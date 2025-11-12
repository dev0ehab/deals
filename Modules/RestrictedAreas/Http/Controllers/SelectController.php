<?php

namespace Modules\RestrictedAreas\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\RestrictedAreas\Entities\RestrictedArea;
use Modules\RestrictedAreas\Transformers\RestrictedAreasResource;
use Modules\Support\Traits\ApiTrait;

class SelectController extends Controller
{
    use ApiTrait;


    public function index()
    {
        $data = RestrictedAreasResource::collection(RestrictedArea::get());
        return $this->sendResponse($data, __('Data Found'));
    }

    public function show(RestrictedArea  $restrictedArea)
    {
        return $this->sendResponse(RestrictedAreasResource::make($restrictedArea), __('Data Found'));
    }
}
