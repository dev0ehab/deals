<?php

namespace Modules\Frontend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Laraeast\LaravelSettings\Facades\Settings;

class LocaleController extends Controller
{
    /**
     * Change the dashboard language.
     *
     * @param string $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($locale)
    {
        Session::put('locale', $locale);

        return back();
    }


    public function change(Request $request)
    {
        Settings::set('theme', $request->theme);
        return redirect()->back();
    }
}
