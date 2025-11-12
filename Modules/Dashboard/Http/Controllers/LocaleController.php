<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{

    /**
     * @param $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($locale)
    {
        Session::put('locale', $locale);

        return back();
    }
}
