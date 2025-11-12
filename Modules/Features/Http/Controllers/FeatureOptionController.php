<?php

namespace Modules\Features\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Features\Entities\Feature;
use Modules\Features\Entities\FeatureOption;
use Modules\Features\Http\Requests\FeatureRequest;
use Modules\Features\Http\Requests\OptionRequest;
use Modules\Features\Repositories\FeatureOptionRepository;

class FeatureOptionController extends Controller
{
    private $repository;

    public function __construct(FeatureOptionRepository $repository)
    {
        $this->middleware('permission:read_features')->only(['index']);
        $this->middleware('permission:create_features')->only(['create', 'store']);
        $this->middleware('permission:update_features')->only(['edit', 'update']);
        $this->middleware('permission:delete_features')->only(['destroy']);
        $this->middleware('permission:show_features')->only(['show']);
        $this->repository = $repository;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param OptionRequest $request
     */
    public function store(Feature $feature, OptionRequest $request)
    {

        $feature = $this->repository->create($feature, $request->validated());

        flash(trans('features::options.messages.created'))->success();

        return redirect()->back();
    }


    /**
     * Display the specified resource.
     *
     * @param Feature $feature
     * @return View
     */
    public function show(Feature $feature, FeatureOption $option)
    {
        return view('features::options.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Feature $feature
     * @return View
     */
    public function edit(Feature $feature, FeatureOption $option)
    {
        return view('features::options.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OptionRequest $request
     * @param Feature $feature
     */
    public function update(OptionRequest $request, Feature $feature, FeatureOption $option)
    {
        $data = $request->validated();

        $option = $this->repository->update($option, $data);

        flash(trans('features::options.messages.updated'))->success();

        return redirect()->route('dashboard.options.show', [$feature, $option]);
    }


    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Feature $feature, FeatureOption $option)
    {
        $this->repository->delete($option);

        flash(trans('features::options.messages.deleted'))->error();

        return redirect()->route('dashboard.features.show', $feature);
    }
}
