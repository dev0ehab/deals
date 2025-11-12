<?php

namespace Modules\Sections\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Sections\Entities\Section;
use Modules\Sections\Http\Requests\SectionRequest;
use Modules\Sections\Repositories\SectionRepository;

class SectionsController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @var SectionRepository
     */
    private $repository;

    /**
     * CountryController constructor.
     *
     * @param SectionRepository $repository
     *
     */
    public function __construct(SectionRepository $repository)
    {
        $this->middleware('permission:read_sections')->only(['index']);
        $this->middleware('permission:create_sections')->only(['create', 'store']);
        $this->middleware('permission:update_sections')->only(['edit', 'update']);
        $this->middleware('permission:delete_sections')->only(['destroy']);
        $this->middleware('permission:show_sections')->only(['show']);

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $sections = $this->repository->all();

        return view('sections::sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        return view('sections::sections.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SectionRequest $request
     */
    public function store(SectionRequest $request)
    {
        $section = $this->repository->create($request->all());

        flash(trans('sections::sections.messages.created'))->success();

        return redirect()->route('dashboard.sections.show', $section);
    }

    /**
     * Display the specified resource.
     *
     * @param Section $section
     * @return View
     */
    public function show(Section $section)
    {
        $section = $this->repository->find($section);
        return view('sections::sections.show', compact('section'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Section $section
     * @return View
     */
    public function edit(Section $section)
    {
        $waypoints = $section->waypoints ;
        return view('sections::sections.edit' , get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SectionRequest $request
     * @param Section $section
     */
    public function update(SectionRequest $request, Section $section)
    {
        $section = $this->repository->update($section, $request->all());

        flash(trans('sections::sections.messages.updated'))->success();

        return redirect()->route('dashboard.sections.show', $section);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Section $section
     */
    public function destroy(Section $section)
    {
        $this->repository->delete($section);

        flash(trans('sections::sections.messages.deleted'))->error();

        return redirect()->route('dashboard.sections.index');
    }
}
