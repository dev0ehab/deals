<?php

namespace Modules\Areas\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Areas\Entities\Area;
use Modules\Areas\Http\Requests\AreaRequest;
use Modules\Areas\Repositories\AreaRepository;

class AreasController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @var AreaRepository
     */
    private $repository;

    /**
     * CountryController constructor.
     *
     * @param AreaRepository $repository
     *
     */
    public function __construct(AreaRepository $repository)
    {
        $this->middleware('permission:read_areas')->only(['index']);
        $this->middleware('permission:create_areas')->only(['create', 'store']);
        $this->middleware('permission:update_areas')->only(['edit', 'update']);
        $this->middleware('permission:delete_areas')->only(['destroy']);
        $this->middleware('permission:show_areas')->only(['show']);

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $areas = $this->repository->all();

        return view('areas::areas.index', compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('areas::areas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AreaRequest $request
     */
    public function store(AreaRequest $request)
    {
        $area = $this->repository->create($request->all());

        flash(trans('areas::areas.messages.created'))->success();

        return redirect()->route('dashboard.areas.show', $area);
    }

    /**
     * Display the specified resource.
     *
     * @param Area $area
     * @return View
     */
    public function show(Area $area)
    {
        $area = $this->repository->find($area);
        return view('areas::areas.show', compact('area'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Area $area
     * @return View
     */
    public function edit(Area $area)
    {
        $waypoints = $area->waypoints ;
        return view('areas::areas.edit' , get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AreaRequest $request
     * @param Area $area
     */
    public function update(AreaRequest $request, Area $area)
    {
        $area = $this->repository->update($area, $request->all());

        flash(trans('areas::areas.messages.updated'))->success();

        return redirect()->route('dashboard.areas.show', $area);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Area $area
     */
    public function destroy(Area $area)
    {
        $this->repository->delete($area);

        flash(trans('areas::areas.messages.deleted'))->error();

        return redirect()->route('dashboard.areas.index');
    }
}
