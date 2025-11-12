<?php

namespace Modules\Settings\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\ContactUs;
use Modules\Settings\Http\Requests\Api\ContactsRequest;
use Modules\Support\Traits\ApiTrait;

class ContactUsController extends Controller
{
    use ApiTrait;

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function save(ContactsRequest $request): JsonResponse
    {
        $data = ContactUs::create($request->except('_token'));
        return $this->sendSuccess(__('settings::settings.messages.contact'));
    }



}
