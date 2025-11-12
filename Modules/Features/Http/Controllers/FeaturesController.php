<?php

namespace Modules\Features\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Features\Entities\Feature;
use Modules\Features\Http\Requests\FeatureRequest;
use Modules\Features\Repositories\FeatureOptionRepository;
use Modules\Features\Repositories\FeatureRepository;
use Modules\Features\Repositories\SubFeaturesRepository;

class FeaturesController extends Controller
{
    private $repository;
    private $subFeatureRepository;
    private $featureOptionRepository;

    public function __construct(FeatureRepository $repository, SubFeaturesRepository $subFeatureRepository , FeatureOptionRepository $featureOptionRepository)
    {
        $this->middleware('permission:read_features')->only(['index']);
        $this->middleware('permission:create_features')->only(['create', 'store']);
        $this->middleware('permission:update_features')->only(['edit', 'update']);
        $this->middleware('permission:delete_features')->only(['destroy']);
        $this->middleware('permission:show_features')->only(['show']);
        $this->repository = $repository;
        $this->subFeatureRepository = $subFeatureRepository;
        $this->featureOptionRepository = $featureOptionRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $features = $this->repository->all();

        return view('features::features.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        $features = Feature::listsTranslations('name')->pluck('name', 'id')->toArray();

        return view('features::features.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FeatureRequest $request
     */
    public function store(FeatureRequest $request)
    {
        $feature = $this->repository->create($request->except('_token'));

        flash(trans('features::features.messages.created'))->success();

        return redirect()->route('dashboard.features.show', $feature);
    }


    /**
     * Display the specified resource.
     *
     * @param Feature $feature
     * @return View
     */
    public function show(Feature $feature)
    {
        $feature = $this->repository->find($feature);
        $sub_features = $this->subFeatureRepository->all($feature);
        $options = $this->featureOptionRepository->all($feature);

        return view('features::features.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Feature $feature
     * @return View
     */
    public function edit(Feature $feature)
    {
        $feature = $this->repository->find($feature);
        $features = Feature::listsTranslations('name')->pluck('name', 'id')->toArray();
        $options = $feature->options;
        return view('features::features.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FeatureRequest $request
     * @param Feature $feature
     */
    public function update(FeatureRequest $request, Feature $feature)
    {
        $feature = $this->repository->update($feature, $request->all());

        flash(trans('features::features.messages.updated'))->success();

        return redirect()->route('dashboard.features.show', $feature);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Feature $feature
     */
    public function destroy(Feature $feature)
    {
        $this->repository->delete($feature);

        flash(trans('features::features.messages.deleted'))->error();

        return redirect()->route('dashboard.features.index');
    }


    public function getOrder()
    {
        $features = $this->repository->order();
        return view('features::features.order', get_defined_vars());
    }


    public function order(Request $request)
    {
        foreach ($request->features as $key => $feature) {
            $rank = $key + 1;
            Feature::where('id', $feature)->update([
                'rank' => $rank,
            ]);
        }

        flash(trans('features::features.messages.ordered'))->success();

        return redirect()->route('dashboard.order.form.features');
    }

}
