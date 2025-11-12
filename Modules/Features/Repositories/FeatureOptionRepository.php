<?php

namespace Modules\Features\Repositories;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Modules\Features\Entities\FeatureOption;
use Modules\Contracts\ChildCrudRepository;

class FeatureOptionRepository implements ChildCrudRepository
{


    /**
     * Get all clients as a collection.
     *
     * @return LengthAwarePaginator
     */
    public function all($parent)
    {
        return $parent->options()->latest()->paginate(request('perPage'));
    }

    /**
     * Save the created model to storage.
     *
     * @param array $data
     * @return FeatureOption
     */
    public function create($parent, array $data)
    {
        $option = $parent->options()->create($data);

        if (isset($data['image'])) {
            $option->addMediaFromRequest('image')->toMediaCollection('images');
        }

        return $option;
    }

    /**
     * Display the given user instance.
     *
     * @param mixed $model
     * @return FeatureOption
     */
    public function find($model)
    {
        if ($model instanceof FeatureOption) {
            return $model;
        }

        return FeatureOption::findOrFail($model);
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
        $option = $this->find($model);

        $option->update($data);

        if (isset($data['image'])) {
            $option->clearMediaCollection('images');
            $option->addMediaFromRequest('image')->toMediaCollection('images');
        }

        return $option;
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
