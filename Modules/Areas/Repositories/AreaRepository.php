<?php

namespace Modules\Areas\Repositories;

use Modules\Contracts\CrudRepository;
use Modules\Areas\Entities\Area;
use Modules\Areas\Http\Filters\AreaFilter;

class AreaRepository implements CrudRepository
{
    /**
     * @var \Modules\Areas\Http\Filters\AreaFilter
     */
    private $filter;

    /**
     * AreaRepository constructor.
     *
     * @param \Modules\Areas\Http\Filters\AreaFilter $filter
     */
    public function __construct(AreaFilter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Get all Areas as a collection.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all()
    {
        return Area::filter($this->filter)->paginate(request('perPage'));
    }

    /**
     * Save the created model to storage.
     *
     * @param array $data
     * @return \Modules\Areas\Entities\Area
     */
    public function create(array $data)
    {
        // $data['waypoints'] = json_encode($data['waypoints'], true);
        $area = Area::create($data);

        return $area;
    }

    /**
     * Display the given Area instance.
     *
     * @param mixed $model
     * @return \Modules\Areas\Entities\Area
     */
    public function find($model)
    {
        if ($model instanceof Area) {
            return $model;
        }

        return Area::findOrFail($model);
    }

    /**
     * Update the given Area in the storage.
     *
     * @param mixed $model
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($model, array $data)
    {
        $area = $this->find($model);

        // $data['waypoints'] = json_encode($data['waypoints'], true);

        $area->update($data);

        return $area;
    }

    /**
     * Delete the given Area from storage.
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
