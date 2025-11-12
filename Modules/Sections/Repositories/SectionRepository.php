<?php

namespace Modules\Sections\Repositories;

use Modules\Contracts\CrudRepository;
use Modules\Sections\Entities\Section;
use Modules\Sections\Http\Filters\SectionFilter;

class SectionRepository implements CrudRepository
{
    /**
     * @var \Modules\Sections\Http\Filters\SectionFilter
     */
    private $filter;

    /**
     * SectionRepository constructor.
     *
     * @param \Modules\Sections\Http\Filters\SectionFilter $filter
     */
    public function __construct(SectionFilter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Get all Sections as a collection.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all()
    {
        return Section::filter($this->filter)->paginate(request('perPage'));
    }

    /**
     * Save the created model to storage.
     *
     * @param array $data
     * @return \Modules\Sections\Entities\Section
     */
    public function create(array $data)
    {
        $section = Section::create($data);

        if (isset($data['image'])) {
            $section->addMediaFromRequest('image')->toMediaCollection('images');
        }

        return $section;
    }

    /**
     * Display the given Section instance.
     *
     * @param mixed $model
     * @return \Modules\Sections\Entities\Section
     */
    public function find($model)
    {
        if ($model instanceof Section) {
            return $model;
        }

        return Section::findOrFail($model);
    }

    /**
     * Update the given Section in the storage.
     *
     * @param mixed $model
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($model, array $data)
    {
        $section = $this->find($model);

        $section->update($data);

        if (isset($data['image'])) {
            $section->clearMediaCollection('images');
            $section->addMediaFromRequest('image')->toMediaCollection('images');
        }

        return $section;
    }

    /**
     * Delete the given Section from storage.
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
