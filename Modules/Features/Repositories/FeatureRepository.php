<?php

namespace Modules\Features\Repositories;

use Modules\Contracts\CrudRepository;
use Modules\Features\Entities\Feature;
use Modules\Features\Http\Filters\FeatureFilter;

class FeatureRepository implements CrudRepository
{
    /**
     * @var \Modules\Features\Http\Filters\FeatureFilter
     */
    private $filter;

    /**
     * FeatureRepository constructor.
     *
     * @param \Modules\Features\Http\Filters\FeatureFilter $filter
     */
    public function __construct(FeatureFilter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Get all Features as a collection.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all()
    {
        return Feature::parentFeature()->orderBy('rank', 'asc')->filter($this->filter)->paginate(request('perPage'));
    }

    /**
     * Get all Features as a collection.
     *
     */
    public function order()
    {
        return Feature::parentFeature()->orderBy('rank', 'asc')->filter($this->filter)->get();
    }

    /**
     * Save the created model to storage.
     *
     * @param array $data
     * @return \Modules\Features\Entities\Feature
     */
    public function create(array $data)
    {
        /** @var Feature $feature */
        $feature = Feature::create($data);

        $feature->update(['rank' => $feature->id]);

        $feature->addMediaFromRequest('image')->toMediaCollection('images');

        if (isset($data['cover'])) {
            $feature->addMediaFromRequest('cover')->toMediaCollection('covers');
        }


        return $feature;
    }

    /**
     * Display the given Feature instance.
     *
     * @param mixed $model
     * @return \Modules\Features\Entities\Feature
     */
    public function find($model)
    {
        if ($model instanceof Feature) {
            return $model;
        }

        return Feature::findOrFail($model);
    }

    /**
     * Update the given Feature in the storage.
     *
     * @param mixed $model
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($model, array $data)
    {
        $feature = $this->find($model);

        $feature->update($data);

        if (isset($data['image'])) {
            $feature->clearMediaCollection('images');
            $feature->addMediaFromRequest('image')->toMediaCollection('images');
        }
        if (isset($data['cover'])) {
            $feature->clearMediaCollection('covers');
            $feature->addMediaFromRequest('cover')->toMediaCollection('covers');
        }


        return $feature;
    }

    /**
     * Delete the given Feature from storage.
     *
     * @param mixed $model
     * @return void
     * @throws \Exception
     */
    public function delete($model)
    {
        $this->find($model)->delete();
    }
}
