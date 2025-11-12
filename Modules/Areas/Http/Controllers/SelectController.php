<?php

namespace Modules\Areas\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Areas\Entities\Area;
use Modules\Areas\Transformers\AreasResource;
use Modules\Support\Traits\ApiTrait;

class SelectController extends Controller
{
    use ApiTrait;


    public function index()
    {
        $data = AreasResource::collection(Area::get());
        return $this->sendResponse($data, __('Data Found'));
    }

    public function show(Area  $area)
    {
        return $this->sendResponse(AreasResource::make($area), __('Data Found'));
    }
}
