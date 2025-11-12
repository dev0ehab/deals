<?php

namespace Modules\Settings\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\AboutUs;

class AboutUsController extends Controller
{

    public function form()
    {
        $about = AboutUs::first();
        return view('settings::settings.tabs.about', compact('about'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $about = AboutUs::first();
        if ($about) {
            $about->update($request->all());
        } else {
            $about = AboutUs::create($request->all());
        }

        flash(trans('settings::settings.messages.update_about'))->success();

        return redirect()->back();
    }

    public function map1()
    {
        $about = AboutUs::first();
        $page = "map1";
        return view('settings::settings.tabs.map', compact('about', 'page'));
    }

    public function map2()
    {
        $about = AboutUs::first();
        $page = "map2";
        return view('settings::settings.tabs.map', compact('about', 'page'));
    }

}
