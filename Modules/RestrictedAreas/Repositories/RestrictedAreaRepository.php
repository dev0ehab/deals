<?php

namespace Modules\RestrictedAreas\Repositories;

use Modules\Contracts\CrudRepository;
use Modules\RestrictedAreas\Entities\RestrictedArea;
use Modules\RestrictedAreas\Http\Filters\RestrictedAreaFilter;

class RestrictedAreaRepository implements CrudRepository
{
    /**
     * @var \Modules\RestrictedAreas\Http\Filters\RestrictedAreaFilter
     */
    private $filter;

    /**
     * RestrictedAreaRepository constructor.
     *
     * @param \Modules\RestrictedAreas\Http\Filters\RestrictedAreaFilter $filter
     */
    public function __construct(RestrictedAreaFilter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Get all RestrictedAreas as a collection.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all()
    {
        return RestrictedArea::filter($this->filter)->paginate(request('perPage'));
    }

    /**
     * Save the created model to storage.
     *
     * @param array $data
     * @return \Modules\RestrictedAreas\Entities\RestrictedArea
     */
    public function create(array $data)
    {
        // $data['waypoints'] = json_encode($data['waypoints'], true);
        $restricted_area = RestrictedArea::create($data);

        return $restricted_area;
    }

    /**
     * Display the given RestrictedArea instance.
     *
     * @param mixed $model
     * @return \Modules\RestrictedAreas\Entities\RestrictedArea
     */
    public function find($model)
    {
        if ($model instanceof RestrictedArea) {
            return $model;
        }

        return RestrictedArea::findOrFail($model);
    }

    /**
     * Update the given RestrictedArea in the storage.
     *
     * @param mixed $model
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($model, array $data)
    {
        $restricted_area = $this->find($model);

        // $data['waypoints'] = json_encode($data['waypoints'], true);

        $restricted_area->update($data);

        return $restricted_area;
    }

    /**
     * Delete the given RestrictedArea from storage.
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
