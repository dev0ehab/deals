<?php

namespace Modules\Advertisements\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Advertisements\Entities\Advertisement;
use Modules\Advertisements\Http\Filters\SelectFilter;
use Modules\Advertisements\Transformers\AdvertisementsResource;
use Modules\Support\Traits\ApiTrait;

class SelectController extends Controller
{
    use ApiTrait;

    public function index(SelectFilter $filter)
    {
        $data = AdvertisementsResource::collection(Advertisement::filter($filter)->active()->get());
        return $this->sendResponse($data, __('Data Found'));
    }

    public function show(Advertisement $advertisement)
    {
        $data = new AdvertisementsResource($advertisement);
        return $this->sendResponse($data, __('Data Found'));
    }

}
