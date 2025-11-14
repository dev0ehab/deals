<?php

namespace Modules\Vendors\Http\Controllers\Dashboard;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Modules\Vendors\Entities\Vendor;
use Modules\Vendors\Http\Requests\UserRequest;
use Modules\Vendors\Repositories\VendorRepository;

class UserController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * The repository instance.
     *
     * @var VendorRepository
     */
    private $repository;

    /**
     * AdminController constructor.
     *
     * @param VendorRepository $repository
     */
    public function __construct(VendorRepository $repository)
    {
        $this->middleware('permission:read_vendors')->only(['index']);
        $this->middleware('permission:create_vendors')->only(['create', 'store']);
        $this->middleware('permission:update_vendors')->only(['edit', 'update']);
        $this->middleware('permission:delete_vendors')->only(['destroy']);
        $this->middleware('permission:show_vendors')->only(['show']);
        $this->middleware('permission:readTrashed_vendors')->only(['trashed']);
        $this->middleware('permission:restore_vendors')->only(['restore']);
        $this->middleware('permission:forceDelete_vendors')->only(['forceDelete']);
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $vendors = $this->repository->all();
        return view('vendors::vendorsindex', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('vendors::vendorscreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(UserRequest $request)
    {
        $vendor = $this->repository->create($request->allWithHashedPassword());

        flash(trans('vendors::vendors.messages.created'))->success();

        return redirect()->route('dashboard.vendors.show', $vendor);
    }

    /**
     * Display the specified resource.
     *
     * @param Vendor $vendor
     * @return Application|Factory|View
     */
    public function show(Vendor $vendor)
    {
        $vendor = $this->repository->find($vendor);

        return view('vendors::vendorsshow', compact('vendor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Vendor $vendor
     * @return Application|Factory|View
     */
    public function edit(Vendor $vendor)
    {
        $vendor = $this->repository->find($vendor);

        return view('vendors::vendorsedit', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param Vendor $vendor
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(UserRequest $request, Vendor $vendor)
    {
        $vendor = $this->repository->update($vendor, $request->allWithHashedPassword());
        if ($request->has('password')) {
            $vendor->sendSmsNewPasswordNotification($request->password);
        }
        flash(trans('vendors::vendors.messages.updated'))->success();

        return redirect()->route('dashboard.vendors.show', $vendor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Vendor $vendor
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Vendor $vendor)
    {
        if (auth()->user()->is($vendor)) {
            abort(403, 'cannot be deleted due to that your account.');
        }

        $this->repository->delete($vendor);

        flash(trans('vendors::vendors.messages.deleted'))->error();

        return redirect()->route('dashboard.vendors.index');
    }

    /**
     * @param Vendor $vendor
     * @return RedirectResponse
     * @throws Exception
     */
    public function block(Vendor $vendor)
    {
        $this->repository->block($vendor);

        flash(trans('vendors::vendors.messages.blocked'))->success();

        return redirect()->route('dashboard.vendors.index');
    }

    /**
     * @param Vendor $vendor
     * @return RedirectResponse
     * @throws Exception
     */
    public function unblock(Vendor $vendor)
    {
        $this->repository->unblock($vendor);

        flash(trans('vendors::vendors.messages.unblocked'))->success();

        return redirect()->route('dashboard.vendors.index');
    }

    /**
     *  Display a listing of the trashed resource.
     * @param Vendor $vendor
     * @return View
     */
    public function trashed()
    {
        $vendors = $this->repository->trashed();
        return view('vendors::vendorstrashed', compact('vendors'));
    }

    /**
     * force delete the specified resource from storage.
     * @param Vendor $vendor
     * @return View
     */
    public function forceDelete($id)
    {
        $vendor = Vendor::withTrashed()->find($id);

        $this->repository->forceDelete($vendor);

        flash(trans('vendors::vendors.messages.forceDeleted'))->error();

        return redirect()->route('dashboard.vendors.trashed');
    }

    /**
     * Restore the specified resource from storage.
     * @param Vendor $vendor
     * @return View
     */
    public function restore($id)
    {
        $vendor = Vendor::withTrashed()->find($id);

        $this->repository->restore($vendor);

        flash(trans('vendors::vendors.messages.restored'))->success();

        return redirect()->route('dashboard.vendors.trashed');
    }
}
