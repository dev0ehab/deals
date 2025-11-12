<?php

namespace Modules\Settings\Http\Controllers\Dashboard;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\ContactUs;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = ContactUs::get();
        return view('settings::contact-us.index', compact('data'));
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $contact = ContactUs::find($id);
        return view('settings::contact-us.show', compact('contact'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function destroy($id)
    {
        $contact = ContactUs::find($id);
        $contact->delete();
        return redirect()->route('dashboard.contact-us.index')->with('success', trans('settings::contactus.messages.deleted'));
    }
}
