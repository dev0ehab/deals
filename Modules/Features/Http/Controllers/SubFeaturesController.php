<?php

namespace Modules\Features\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Features\Entities\Feature;
use Modules\Features\Http\Requests\FeatureRequest;
use Modules\Features\Repositories\SubFeaturesRepository;

class SubFeaturesController extends Controller
{
    private $repository;

    public function __construct(SubFeaturesRepository $repository)
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
     * @param FeatureRequest $request
     */
    public function store(Feature $feature, FeatureRequest $request)
    {
        $data = $request->except('_token');

        $feature = $this->repository->create($feature, $data);

        flash(trans('features::sub_features.messages.created'))->success();

        return redirect()->back();
    }


    /**
     * Display the specified resource.
     *
     * @param Feature $feature
     * @return View
     */
    public function show(Feature $feature, $sub_feature)
    {
        $sub_feature = $this->repository->find($sub_feature);

        $sub_features = $this->repository->all($sub_feature);

        return view('features::sub_features.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Feature $feature
     * @return View
     */
    public function edit(Feature $feature, $sub_feature)
    {
        $feature = $this->repository->find($sub_feature);
        $features = Feature::listsTranslations('name')->pluck('name', 'id')->toArray();

        return view('features::sub_features.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FeatureRequest $request
     * @param Feature $feature
     */
    public function update(FeatureRequest $request, Feature $feature, $sub_feature)
    {
        $data = $request->all();

        $data = $request->except('_token');

        $feature = $this->repository->update($sub_feature, $data);

        flash(trans('features::sub_features.messages.updated'))->success();

        return redirect()->route('dashboard.sub_features.show', $sub_feature);
    }


    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Feature $feature, Feature $sub_feature)
    {
        $this->repository->delete($sub_feature);

        flash(trans('features::features.messages.deleted'))->error();

        return redirect()->route('dashboard.features.show', $feature);
    }
}
