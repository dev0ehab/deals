<?php

namespace Modules\Attributes\Repositories;

use Modules\Contracts\CrudRepository;
use Modules\Attributes\Entities\Attribute;
use Modules\Attributes\Http\Filters\AttributeFilter;

class AttributeRepository implements CrudRepository
{
    /**
     */
    private $filter;

    /**
     * AttributeRepository constructor.
     *
     */
    public function __construct(AttributeFilter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Get all Attributes as a collection.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all()
    {
        return Attribute::latest()->filter($this->filter)->paginate(request('perPage'));
    }


    /**
     * Save the created model to storage.
     *
     * @param array $data
     * @return \Modules\Attributes\Entities\Attribute
     */
    public function create(array $data)
    {

        $attribute = Attribute::create($data);

        if (isset($data['options'])) {
            foreach ($data['options'] as $option) {
                $optionModel = $attribute->options()->create($option);

                if (isset($option['image'])) {
                    $optionModel->addMedia($option['image'])->toMediaCollection('images');
                }

                if (isset($option['icon'])) {
                    $optionModel->addMedia($option['icon'])->toMediaCollection('icons');
                }
            }
        }
        return $attribute;
    }

    /**
     * Display the given Addition instance.
     *
     * @param mixed $model
     * @return \Modules\Attributes\Entities\Attribute
     */
    public function find($model)
    {
        if ($model instanceof Attribute) {
            return $model;
        }

        return Attribute::findOrFail($model);
    }

    /**
     * Update the given Addition in the storage.
     *
     * @param mixed $model
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($model, array $data)
    {
        $attribute = $this->find($model);

        $attribute->update($data);

        if (isset($data['options'])) {
            $attribute->options()->whereNotIn('id', array_column($data['options'], 'id'))->each(function ($option) {
                $option->delete();
            });
            foreach ($data['options'] as $option) {
                $optionModel = $attribute->options()->updateOrCreate(['id' => data_get($option, 'id')], $option);

                if (isset($option['image'])) {
                    $optionModel->clearMediaCollection('images');
                    $optionModel->addMedia($option['image'])->toMediaCollection('images');
                }

                if (isset($option['icon'])) {
                    $optionModel->clearMediaCollection('icons');
                    $optionModel->addMedia($option['icon'])->toMediaCollection('icons');
                }
            }
        }

        return $attribute;
    }

    /**
     * Delete the given Addition from storage.
     *
     * @param mixed $model
     * @return void
     * @throws \Exception
     */
    public function delete($model)
    {
        $this->find($model)->delete();
    }



    /**
     * Retrieve all Attributes ordered by rank in ascending order.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function order()
    {
        return Attribute::orderBy('rank', 'asc')->filter($this->filter)->get();
    }

}
