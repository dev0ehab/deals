<?php

namespace Modules\Settings\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\Setting;
use Modules\Settings\Transformers\AppResource;
use Modules\Settings\Transformers\ContactResource;
use Modules\Settings\Transformers\GeneralResource;
use Modules\Settings\Transformers\PageResource;
use Modules\Settings\Transformers\SettingResource;
use Modules\Support\Traits\ApiTrait;
use Settings;

class SettingController extends Controller
{
    use ApiTrait;

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function contact(): JsonResponse
    {
        $data = new ContactResource(Setting::class);
        return $this->sendResponse($data, 'success');
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function general(): JsonResponse
    {
        $data = new GeneralResource(Setting::class);
        return $this->sendResponse($data, 'success');
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function privacy(): JsonResponse
    {
        $page = Settings::locale(app()->getLocale())->get('privacy_content');
        $data = new PageResource($page);
        return $this->sendResponse($data, 'success');
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function about(): JsonResponse
    {
        $page = Settings::locale(app()->getLocale())->get('aboutus_content');
        $data = new PageResource($page);
        return $this->sendResponse($data, 'success');
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function terms(): JsonResponse
    {
        $page = Settings::locale(app()->getLocale())->get('terms_content');
        $data = new PageResource($page);
        return $this->sendResponse($data, 'success');
    }

}
