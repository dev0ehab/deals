<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Modules\Accounts\Entities\User;
use Modules\Settings\Entities\ContactUs;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $users = User::whereDoesntHave("roles")->count() ;

        $messages =  ContactUs::orderBy('created_at', 'desc')->take(4)->get();
        return view('dashboard::index', get_defined_vars());
    }
}
