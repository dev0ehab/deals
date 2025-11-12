<?php

namespace Modules\Advertisements\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Advertisements\Entities\Advertisement;
use Modules\Advertisements\Http\Requests\AdvertisementRequest;
use Modules\Advertisements\Repositories\AdvertisementRepository;
use Modules\Washers\Entities\Washer;

class AdvertisementsController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @var AdvertisementRepository
     */
    private $repository;

    /**
     * AdvertisementController constructor.
     *
     * @param AdvertisementRepository $repository
     */
    public function __construct(AdvertisementRepository $repository)
    {
        $this->middleware('permission:read_advertisements')->only(['index']);
        $this->middleware('permission:create_advertisements')->only(['create', 'store']);
        $this->middleware('permission:update_advertisements')->only(['edit', 'update']);
        $this->middleware('permission:delete_advertisements')->only(['destroy']);
        $this->middleware('permission:show_advertisements')->only(['show']);

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $advertisements = $this->repository->all();
        return view('advertisements::advertisements.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('advertisements::advertisements.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdvertisementRequest $request
     * @return RedirectResponse
     */
    public function store(AdvertisementRequest $request)
    {
        $advertisement = $this->repository->create($request->all());

        flash(trans('advertisements::advertisements.messages.created'))->success();

        return redirect()->route('dashboard.advertisements.show', $advertisement);
    }

    /**
     * Display the specified resource.
     *
     * @param Advertisement $advertisement
     *
     */
    public function show(Advertisement $advertisement)
    {
        $advertisement = $this->repository->find($advertisement);

        return view('advertisements::advertisements.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Advertisement $advertisement
     * @return View
     */
    public function edit(Advertisement $advertisement)
    {
        return view('advertisements::advertisements.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdvertisementRequest $request
     * @param Advertisement $advertisement
     * @return RedirectResponse
     */
    public function update(AdvertisementRequest $request, Advertisement $advertisement)
    {
        $advertisement = $this->repository->update($advertisement, $request->all());

        flash(trans('advertisements::advertisements.messages.updated'))->success();

        return redirect()->route('dashboard.advertisements.show', $advertisement);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Advertisement $advertisement
     * @return RedirectResponse
     */
    public function destroy(Advertisement $advertisement)
    {
        $this->repository->delete($advertisement);

        flash(trans('advertisements::advertisements.messages.deleted'))->error();

        return redirect()->route('dashboard.advertisements.index');
    }


    public function getOrder()
    {
        $advertisements = Advertisement::orderBy('rank', 'asc')->get();
        return view('advertisements::advertisements.order', compact('advertisements'));
    }


    public function order(Request $request)
    {
        foreach ($request->advertisements as $key => $advertisement) {
            $rank = $key + 1;
            Advertisement::where('id', $advertisement)->update([
                'rank' => $rank,
            ]);
        }

        flash(trans('advertisements::advertisements.messages.ordered'))->success();

        return redirect()->route('dashboard.order.form.advertisements');
    }



    /**
     * Remove the specified resource from storage.
     * @param Advertisement $advertisement
     * @return RedirectResponse
     */
    public function activate(Request $request, Advertisement $advertisement)
    {
        activate($advertisement, $request->status);
        $msg = $advertisement->isActive() ? __("advertisements::advertisements.messages.activated") : __("advertisements::advertisements.messages.deactivated");
        return response()->json([
            'active' => $advertisement->active,
            'msg' => $msg,
        ], 200);
    }
}
