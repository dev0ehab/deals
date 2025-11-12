<?php

namespace Modules\Sections\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Sections\Entities\Section;
use Modules\Sections\Transformers\SectionsResource;
use Modules\Support\Traits\ApiTrait;

class SelectController extends Controller
{
    use ApiTrait;


    public function index()
    {
        $data = SectionsResource::collection(Section::get());
        return $this->sendResponse($data, __('Data Found'));
    }

    public function show(Section  $section)
    {
        return $this->sendResponse(SectionsResource::make($section), __('Data Found'));
    }
}
