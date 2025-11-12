<?php

namespace Modules\FAQs\Repositories;

use Modules\Contracts\CrudRepository;
use Modules\FAQs\Entities\FAQ;
use Modules\FAQs\Http\Filters\FAQFilter;

class FAQRepository implements CrudRepository
{
    /**
     * @var \Modules\FAQs\Http\Filters\FAQFilter
     */
    private $filter;

    /**
     * FAQRepository constructor.
     *
     * @param \Modules\FAQs\Http\Filters\FAQFilter $filter
     */
    public function __construct(FAQFilter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Get all FAQs as a collection.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all()
    {
        return FAQ::filter($this->filter)->paginate(request('perPage'));
    }

    /**
     * Save the created model to storage.
     *
     * @param array $data
     * @return \Modules\FAQs\Entities\FAQ
     */
    public function create(array $data)
    {
        /** @var FAQ $f_a_q */
        $f_a_q = FAQ::create($data);

        return $f_a_q;
    }

    /**
     * Display the given FAQ instance.
     *
     * @param mixed $model
     * @return \Modules\FAQs\Entities\FAQ
     */
    public function find($model)
    {
        if ($model instanceof FAQ) {
            return $model;
        }

        return FAQ::findOrFail($model);
    }

    /**
     * Update the given FAQ in the storage.
     *
     * @param mixed $model
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($model, array $data)
    {
        $f_a_q = $this->find($model);

        $f_a_q->update($data);

        return $f_a_q;
    }

    /**
     * Delete the given FAQ from storage.
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
