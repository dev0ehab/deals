<?php

namespace Modules\Features\Http\Controllers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use Laraeast\LaravelSettings\Facades\Settings;
use Modules\Features\Entities\Feature;
use Modules\Features\Entities\FeatureOption;
use Modules\Features\Http\Filters\SelectFilter;
use Modules\Features\Transformers\FeatureDetailsResource;
use Modules\Features\Transformers\FeatureResource;
use Modules\Features\Transformers\FeatureSelectResource;
use Modules\Support\Traits\ApiTrait;

class SelectController extends Controller
{
    use ApiTrait;
    /**
     * Display a listing of the resource.
     *
     * @param SelectFilter $filter
     * @return AnonymousResourceCollection
     */
    public function features(SelectFilter $filter)
    {
        $features = Feature::filter($filter)->parentFeature()->get();

        return FeatureSelectResource::collection($features);
    }

    /**
     * Display a listing of the resource.
     *
     * @param SelectFilter $filter
     */
    public function allFeatures()
    {
        $features = Feature::parentFeature()->orderBy("rank")->get();
        $data = [
            "show" => (bool) Settings::get('Feature'),
            "header" => Settings::locale(app()->getLocale())->get('feature_header'),
            "features" => FeatureResource::collection($features)
        ];
        return $this->sendResponse($data, 'success');
    }


    public function getByName($name)
    {
        $feature = Feature::whereTranslation('name', $name)->first();
        if (!$feature) {
            return $this->sendError(__("Not Found"));
        }
        $data = new FeatureDetailsResource($feature);
        return $this->sendResponse($data, "success");
    }

    public function featureOptions($featureId)
    {
        $options = FeatureOption::where('feature_id', $featureId)->get();

        $data = [
            'options' => $options->map(function($option) {
                return [
                    'id' => $option->id,
                    'name' => $option->name,
                ];
            })
        ];

        return response()->json($data);
    }


    public function optionsByFeatureId($featureId)
    {
        $options = FeatureOption::where('feature_id', $featureId)->get();


        return $this->sendResponse($options->toArray(), 'success');
    }
}
