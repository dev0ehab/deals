<?php

namespace Modules\Features\Repositories;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Modules\Features\Entities\Feature;
use Modules\Features\Http\Filters\FeatureFilter;
use Modules\Contracts\ChildCrudRepository;

class SubFeaturesRepository implements ChildCrudRepository
{
    /**
     * @var FeatureFilter
     */
    private $filter;

    /**
     * UserRepository constructor.
     *
     * @param FeatureFilter $filter
     */
    public function __construct(FeatureFilter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Get all clients as a collection.
     *
     * @return LengthAwarePaginator
     */
    public function all($parent)
    {
        return $parent->subFeatures()->filter($this->filter)->latest()->paginate(request('perPage'));
    }

    /**
     * Save the created model to storage.
     *
     * @param array $data
     * @return Feature
     */
    public function create($parent, array $data)
    {
        $feature = $parent->subFeatures()->create($data);

        if (isset($data['image'])) {
            $feature->addMediaFromRequest('image')->toMediaCollection('images');
        }

        if (isset($data['additional_image'])) {
            $feature->addMediaFromRequest('additional_image')->toMediaCollection('additional_images');
        }

        return $feature;
    }

    /**
     * Display the given user instance.
     *
     * @param mixed $model
     * @return Feature
     */
    public function find($model)
    {
        if ($model instanceof Feature) {
            return $model;
        }

        return Feature::findOrFail($model);
    }

    /**
     * Update the given client in the storage.
     *
     * @param mixed $model
     * @param array $data
     * @return Model
     */
    public function update($model, array $data)
    {
        $feature = $this->find($model);

        $feature->update($data);

        if (isset($data['image'])) {
            $feature->clearMediaCollection('images');
            $feature->addMediaFromRequest('image')->toMediaCollection('images');
        }

        if (isset($data['additional_image'])) {
            $feature->clearMediaCollection('additional_images');
            $feature->addMediaFromRequest('additional_image')->toMediaCollection('additional_images');
        }

        return $feature;
    }

    /**
     * Delete the given client from storage.
     *
     * @param mixed $model
     * @return void
     * @throws Exception
     */
    public function delete($model)
    {
        $this->find($model)->forceDelete();
    }

}
