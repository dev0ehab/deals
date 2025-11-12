<?php

namespace Modules\Settings\Repositories;

use Modules\Contracts\CrudRepository;
use Modules\Settings\Entities\Award;
use Modules\Settings\Http\Filters\AwardFilter;

class AwardRepository implements CrudRepository
{
    /**
     * @var \Modules\Settings\Http\Filters\AwardFilter
     */
    private $filter;

    /**
     * AwardRepository constructor.
     *
     * @param \Modules\Settings\Http\Filters\AwardFilter $filter
     */
    public function __construct(AwardFilter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Get all Settings as a collection.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all()
    {
        return Award::filter($this->filter)->paginate(request('perPage'));
    }

    /**
     * Save the created model to storage.
     *
     * @param array $data
     * @return \Modules\Settings\Entities\Award
     */
    public function create(array $data)
    {
        /** @var Award $award */
        $award = Award::create($data);

        $award->addAllMediaFromTokens();

        return $award;
    }

    /**
     * Display the given Award instance.
     *
     * @param mixed $model
     * @return \Modules\Settings\Entities\Award
     */
    public function find($model)
    {
        if ($model instanceof Award) {
            return $model;
        }

        return Award::findOrFail($model);
    }

    /**
     * Update the given Award in the storage.
     *
     * @param mixed $model
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($model, array $data)
    {
        $award = $this->find($model);

        $award->update($data);

        $award->addAllMediaFromTokens();

        return $award;
    }

    /**
     * Delete the given Award from storage.
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
