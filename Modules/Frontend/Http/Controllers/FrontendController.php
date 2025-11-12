<?php

namespace Modules\Frontend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Services\Entities\Service;
use Modules\Settings\Entities\ContactUs;
use Modules\Sliders\Entities\Slider;
use Modules\Support\Traits\ApiTrait;

class FrontendController extends Controller
{
    use ApiTrait;

    public function index()
    {
        $services = Service::get();
        return view('frontend::index', get_defined_vars());
    }

    public function privacy()
    {
        $services = [];
        return view('frontend::privacy', get_defined_vars());
    }


    public function contactPost(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            // 'subject' => 'required',
            'message' => 'required',
        ], [
            'name.required' => __('frontend::frontend.name_required'),
            'phone.required' => __('frontend::frontend.phone_required'),
            'email.required' => __('frontend::frontend.email_required'),
            'email.email' => __('frontend::frontend.email_email'),
            'subject.required' => __('frontend::frontend.subject_required'),
            'message.required' => __('frontend::frontend.message_required'),
        ]);

        if ($validator->fails()) {
            $firstError = $validator->errors()->first();
            notify()->error($firstError);
            return redirect()->back();
        }

        $contact = ContactUs::create($request->except('_token'));

        return $this->sendSuccess(__('frontend::frontend.contact_success'));
    }


}
