<?php

namespace Modules\RestrictedAreas\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\RestrictedAreas\Entities\RestrictedArea;
use Modules\RestrictedAreas\Http\Requests\RestrictedAreaRequest;
use Modules\RestrictedAreas\Repositories\RestrictedAreaRepository;

class RestrictedAreasController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @var RestrictedAreaRepository
     */
    private $repository;

    /**
     * CountryController constructor.
     *
     * @param RestrictedAreaRepository $repository
     *
     */
    public function __construct(RestrictedAreaRepository $repository)
    {
        $this->middleware('permission:read_restricted_areas')->only(['index']);
        $this->middleware('permission:create_restricted_areas')->only(['create', 'store']);
        $this->middleware('permission:update_restricted_areas')->only(['edit', 'update']);
        $this->middleware('permission:delete_restricted_areas')->only(['destroy']);
        $this->middleware('permission:show_restricted_areas')->only(['show']);

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $restricted_areas = $this->repository->all();

        return view('restricted_areas::restricted_areas.index', compact('restricted_areas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('restricted_areas::restricted_areas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RestrictedAreaRequest $request
     */
    public function store(RestrictedAreaRequest $request)
    {
        $restricted_area = $this->repository->create($request->all());

        flash(trans('restricted_areas::restricted_areas.messages.created'))->success();

        return redirect()->route('dashboard.restricted_areas.show', $restricted_area);
    }

    /**
     * Display the specified resource.
     *
     * @param RestrictedArea $restricted_area
     * @return View
     */
    public function show(RestrictedArea $restricted_area)
    {
        $restricted_area = $this->repository->find($restricted_area);
        return view('restricted_areas::restricted_areas.show', compact('restricted_area'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param RestrictedArea $restricted_area
     * @return View
     */
    public function edit(RestrictedArea $restricted_area)
    {
        $waypoints = $restricted_area->waypoints ;
        return view('restricted_areas::restricted_areas.edit' , get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RestrictedAreaRequest $request
     * @param RestrictedArea $restricted_area
     */
    public function update(RestrictedAreaRequest $request, RestrictedArea $restricted_area)
    {
        $restricted_area = $this->repository->update($restricted_area, $request->all());

        flash(trans('restricted_areas::restricted_areas.messages.updated'))->success();

        return redirect()->route('dashboard.restricted_areas.show', $restricted_area);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param RestrictedArea $restricted_area
     */
    public function destroy(RestrictedArea $restricted_area)
    {
        $this->repository->delete($restricted_area);

        flash(trans('restricted_areas::restricted_areas.messages.deleted'))->error();

        return redirect()->route('dashboard.restricted_areas.index');
    }
}
