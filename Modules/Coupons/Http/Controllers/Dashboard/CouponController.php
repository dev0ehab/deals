<?php

namespace Modules\Coupons\Http\Controllers\Dashboard;

use App\Services\NotificationsService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Accounts\Entities\User;
use Modules\Coupons\Entities\Coupon;
use Modules\Coupons\Http\Requests\CouponRequest;
use Modules\Coupons\Repositories\CouponRepository;
use Modules\Support\Traits\SendNotificationTrait;
use Modules\Washers\Entities\Washer;

class CouponController extends Controller
{
    use AuthorizesRequests, ValidatesRequests, SendNotificationTrait;

    /**
     * @var CouponRepository
     */
    private $repository;
    private $service;

    /**
     * CategoryController constructor.
     * @param CouponRepository $repository
     */
    public function __construct(CouponRepository $repository, NotificationsService $service)
    {
        $this->middleware('permission:read_coupons')->only(['index']);
        $this->middleware('permission:create_coupons')->only(['create', 'store']);
        $this->middleware('permission:update_coupons')->only(['edit', 'update']);
        $this->middleware('permission:delete_coupons')->only(['destroy']);
        $this->middleware('permission:show_coupons')->only(['show']);
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     * @return Factory|View
     */
    public function index()
    {
        $coupons = $this->repository->all();
        return view('coupons::coupons.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     * @return Factory|View
     */
    public function create()
    {
        return view('coupons::coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param CouponRequest $request
     * @return RedirectResponse
     */
    public function store(CouponRequest $request)
    {
        $data = $request->all();

        $data['users'] = ($data['audience'] == 'all') ?
            User::whereDoesntHave('roles')->pluck('id')->toArray() :
            $request->input('users', []);

        $coupon = $this->repository->create($data);

        $users = ($request->audience == 'all') ?
            User::whereDoesntHave('roles')->whereNotNull('device_token')->get() :
            User::whereNotNull('device_token')->find($request->users);


        // dispatch(new UserNotificationJob([$users, NotificationTypesEnum::NewCoupon->value, ["coupons::coupons.messages.new_title"], ["coupons::coupons.messages.new_body", ['code' => $coupon->code]], $coupon]));


        flash(trans('coupons::coupons.messages.created'))->success();
        return redirect()->route('dashboard.coupons.show', $coupon);
    }


    /**
     * Show the specified resource.
     * @param Coupon $coupon
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function show(Coupon $coupon)
    {
        $coupon = $this->repository->find($coupon);

        return view('coupons::coupons.show', compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param Coupon $coupon
     * @return Factory|View
     */
    public function edit(Coupon $coupon)
    {
        return view('coupons::coupons.edit' , compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     * @param CouponRequest $request
     * @param Coupon $coupon
     * @return RedirectResponse
     */
    public function update(CouponRequest $request, Coupon $coupon)
    {
        $data = $request->all();

        $coupon = $this->repository->update($coupon, $data);

        $data['users'] = ($data['audience'] == 'all') ?
            User::whereDoesntHave('roles')->pluck('id')->toArray() :
            $request->input('users', []);


        $users = ($request->audience == 'all') ?
            User::whereDoesntHave('roles')->whereNotNull('device_token')->get() :
            User::whereNotNull('device_token')->find($request->users);


        // $users = $request->audience == 'all' ? [] :
        //     User::whereNotNull('device_token')->find(array_diff($data["users"], $coupon->users));

        // dispatch(new UserNotificationJob([$users, NotificationTypesEnum::UpdateCoupon->value, ["coupons::coupons.messages.update_title"], ["coupons::coupons.messages.update_body", ['code' => $coupon->code]], $coupon]));

        flash(trans('coupons::coupons.messages.updated'))->success();
        return redirect()->route('dashboard.coupons.show', $coupon);
    }

    /**
     * Remove the specified resource from storage.
     * @param Coupon $coupon
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Coupon $coupon)
    {
        $this->repository->delete($coupon);

        flash(trans('coupons::coupons.messages.deleted'))->error();

        return redirect()->route('dashboard.coupons.index');
    }


    /**
     * Remove the specified resource from storage.
     * @param Coupon $coupon
     * @return RedirectResponse
     * @throws Exception
     */
    public function activate(Request $request, Coupon $coupon)
    {
        activate($coupon, $request->status);
        $msg = $coupon->isActive() ? __("coupons::coupons.messages.activated") : __("coupons::coupons.messages.deactivated");
        return response()->json([
            'active' => $coupon->active,
            'msg' => $msg,
        ], 200);
    }
}
