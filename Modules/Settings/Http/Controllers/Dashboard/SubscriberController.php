<?php

namespace Modules\Settings\Http\Controllers\Dashboard;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\Subscriber;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = Subscriber::paginate(10);
        return view('settings::subscribers.index', compact('data'));
    }


    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $subscriber = Subscriber::find($id);
        return view('settings::subscribers.show', compact('subscriber'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function destroy($id)
    {
        $subscriber = Subscriber::find($id);
        $subscriber->delete();
        return redirect()->route('dashboard.subscribers.index')->with('success', trans('settings::subscribers.messages.deleted'));
    }
}

