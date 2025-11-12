<?php

namespace Modules\Orders\Http\Controllers\Dashboard;

use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Orders\Entities\OrderProduct;
use Illuminate\Http\Request;


class RateController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;


    public function __construct()
    {
        $this->middleware('permission:read_orders')->only(['index']);
        $this->middleware('permission:create_orders')->only(['create', 'store']);
        $this->middleware('permission:update_orders')->only(['edit', 'update']);
        $this->middleware('permission:delete_orders')->only(['destroy']);
        $this->middleware('permission:show_orders')->only(['show', 'invoice']);
    }

    /**
     * Display a listing of the resource.
     * @return Factory|View
     */
    public function index()
    {
        $rates = OrderProduct::where('rate', '!=', null)->orderBy('updated_at', 'desc')->paginate(10);
        return view('orders::rates.index', get_defined_vars());
    }


    public function show(OrderProduct $rate)
    {
        return view('orders::rates.show', get_defined_vars());
    }

    public function status(OrderProduct $rate)
    {
        flash(trans('orders::rates.messages.status'))->success();

        return redirect()->back();
    }


    public function activate(Request $request, OrderProduct $rate)
    {
        $rate->update(['is_rate_accepted' => $request->status]);
        $msg = $rate->isActive() ? __("orders::rates.messages.activated") : __("orders::rates.messages.deactivated");
        return response()->json([
            'active' => $rate->isActive(),
            'msg' => $msg,
        ], 200);
    }
}
