<?php

namespace Modules\Attributes\Repositories;

use Modules\Contracts\CrudRepository;
use Modules\Attributes\Entities\Category;
use Modules\Attributes\Http\Filters\CategoryFilter;

class CategoryRepository implements CrudRepository
{
    /**
     * @var CategoryFilter
     */
    private $filter;

    /**
     * CategoryRepository constructor.
     *
     * @param CategoryFilter $filter
     */
    public function __construct(CategoryFilter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Get all Categories as a collection.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all()
    {
        return Category::latest()->filter($this->filter)->paginate(request('perPage'));
    }

    /**
     * Save the created model to storage.
     *
     * @param array $data
     * @return \Modules\Attributes\Entities\Category
     */
    public function create(array $data)
    {
        $category = Category::create($data);

        if (isset($data['icon'])) {
            $category->addMediaFromRequest('icon')->toMediaCollection('icons');
        }

        return $category;
    }

    /**
     * Display the given Category instance.
     *
     * @param mixed $model
     * @return \Modules\Attributes\Entities\Category
     */
    public function find($model)
    {
        if ($model instanceof Category) {
            return $model;
        }

        return Category::findOrFail($model);
    }

    /**
     * Update the given category in the storage.
     *
     * @param mixed $model
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($model, array $data)
    {
        $category = $this->find($model);
        $category->update($data);

        if (isset($data['icon'])) {
            $category->clearMediaCollection('icons');
            $category->addMediaFromRequest('icon')->toMediaCollection('icons');
        }


        return $category;
    }

    /**
     * Delete the given category from storage.
     *
     * @param mixed $model
     * @return void
     */
    public function delete($model)
    {
        $category = $this->find($model);
        $category->delete();
    }


    /**
     * Retrieve all Services ordered by rank in ascending order.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function order()
    {
        return Category::orderBy('rank', 'asc')->filter($this->filter)->get();
    }

}
