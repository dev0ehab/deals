<?php

namespace Modules\Dashboard\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Accounts\Entities\User;
use Modules\Dashboard\Transformers\DashboardCardsResource;
use Modules\Orders\Entities\Order;
use Illuminate\Support\Facades\Auth;

class SelectController extends Controller
{

    public function getCards()
    {
        // start cards
        $data['ordersCount'] = Order::count();
        $data['todayOrdersCount'] = Order::whereDate('created_at', Carbon::today())->count();
        $data['totalSales'] = Order::all()->sum('subtotal');
        $data['todayTotalSales'] = Order::whereDate('created_at', Carbon::today())->sum('subtotal');
        $data['averageOrders'] = Order::avg('subtotal');
        $data['todayAverageOrders'] = Order::whereDate('created_at', Carbon::today())->avg('subtotal');
        // end cards

        $data['orders'] = Order::distinct()
            ->select(DB::raw('count(*) as total'), DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as created_date'))
            ->where('created_at', '>=', DB::raw('DATE(NOW()) - INTERVAL 7 DAY'))->groupBy('created_date')->limit(7)->get();

        $data['sales'] = Order::distinct()
            ->select(DB::raw('sum(subtotal) as subtotal'), DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as created_date'))
            ->where('created_at', '>=', DB::raw('DATE(NOW()) - INTERVAL 7 DAY'))->groupBy('created_date')->limit(7)->get();

        $data['average'] = Order::distinct()
            ->select(DB::raw('round(AVG(subtotal),0) as average'), DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as created_date'))
            ->where('created_at', '>=', DB::raw('DATE(NOW()) - INTERVAL 7 DAY'))->groupBy('created_date')->limit(7)->get();
        // end charts
        return new DashboardCardsResource($data);
    }

    //    public function getCharts()
//    {
//        $data['orders'] = Order::distinct()
//            ->select(DB::raw('count(*) as total'), DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as created_date'))
//            ->where('created_at', '>=', DB::raw('DATE(NOW()) - INTERVAL 7 DAY'))->groupBy('created_date')->limit(7)->get();
//
//        $data['sales'] = Order::distinct()
//            ->select(DB::raw('sum(subtotal) as subtotal'), DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as created_date'))
//            ->where('created_at', '>=', DB::raw('DATE(NOW()) - INTERVAL 7 DAY'))->groupBy('created_date')->limit(7)->get();
//
//        $data['average'] = Order::distinct()
//            ->select(DB::raw('round(AVG(subtotal),0) as average'), DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as created_date'))
//            ->where('created_at', '>=', DB::raw('DATE(NOW()) - INTERVAL 7 DAY'))->groupBy('created_date')->limit(7)->get();
//
//        return new DashboardChartsResource($data);
//    }

    public function filterCards(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        $data['ordersCount'] = Order::whereBetween('created_at', [$start, $end])->count();
        $data['totalSales'] = Order::whereBetween('created_at', [$start, $end])->sum('subtotal');
        $data['averageOrders'] = Order::whereBetween('created_at', [$start, $end])->avg('subtotal');

        $data['orders'] = Order::distinct()
            ->select(DB::raw('count(*) as total'), DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as created_date'))
            ->whereBetween('created_at', [$start, $end])->groupBy('created_date')->limit(7)->get();

        $data['sales'] = Order::distinct()
            ->select(DB::raw('sum(subtotal) as subtotal'), DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as created_date'))
            ->whereBetween('created_at', [$start, $end])->groupBy('created_date')->limit(7)->get();

        $data['average'] = Order::distinct()
            ->select(DB::raw('round(AVG(subtotal),0) as average'), DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as created_date'))
            ->whereBetween('created_at', [$start, $end])->groupBy('created_date')->limit(7)->get();
        return new DashboardCardsResource($data);
    }

    public function getNotificationRealTime(User $user)
    {
        $messageHtml = view('dashboard::layouts.partials.topbar.notifications', ['admin' => $user])->render();
        return response()->json([
            'messageHtml' => $messageHtml,
        ], 200);
    }
}
