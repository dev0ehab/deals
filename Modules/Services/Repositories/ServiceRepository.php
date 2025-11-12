<?php

namespace Modules\Services\Repositories;

use Modules\Contracts\CrudRepository;
use Modules\Services\Entities\Service;
use Modules\Services\Http\Filters\ServiceFilter;
use Settings;

class ServiceRepository implements CrudRepository
{
    protected $files = [
        // 'bridalUpperSectionImage1',
        // 'bridalUpperSectionImage2',
        // 'bridalUpperSectionImage3',

        // 'bridalMiddleSectionImage1',
        // 'bridalMiddleSectionImage2',

        // 'bridalLowerSectionImage1',
        // 'bridalLowerSectionImage2',
        // 'bridalLowerSectionImage3',
    ];

    protected $inputs = [
        // 'readyToWearLowerCollection',
        // 'readyToWearUpperCollection',

        // 'bridalCollection',

        // 'bridalMiddleSectionName:ar',
        // 'bridalMiddleSectionName:en',
        // 'bridalMiddleSectionDescription:ar',
        // 'bridalMiddleSectionDescription:en',

        // 'bridalLowerSectionName:en',
        // 'bridalLowerSectionName:ar',
        // 'bridalLowerSectionDescription:en',
        // 'bridalLowerSectionDescription:ar',
    ];

    /**
     * @var \Modules\Services\Http\Filters\ServiceFilter
     */
    private $filter;

    /**
     * ServiceRepository constructor.
     *
     * @param \Modules\Services\Http\Filters\ServiceFilter $filter
     */
    public function __construct(ServiceFilter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Get all Services as a collection.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all()
    {
        return Service::filter($this->filter)->paginate(request('perPage'));
    }

    /**
     * Retrieve all Services ordered by rank in ascending order.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function order()
    {
        return Service::orderBy('rank', 'asc')->filter($this->filter)->get();
    }

    /**
     * Save the created model to storage.
     *
     * @param array $data
     * @return \Modules\Services\Entities\Service
     */
    public function create(array $data)
    {
        $service = Service::create($data);


        if (isset($data['cover'])) {
            $service->addMediaFromRequest('cover')->toMediaCollection('covers');
        }

        if (isset($data['images'])) {
            foreach ($data['images'] as $image) {
                $service->addMedia($image)->toMediaCollection('images');
            }
        }

        return $service;
    }

    /**
     * Display the given Service instance.
     *
     * @param mixed $model
     * @return \Modules\Services\Entities\Service
     */
    public function find($model)
    {
        if ($model instanceof Service) {
            return $model;
        }

        return Service::findOrFail($model);
    }

    /**
     * Update the given Service in the storage.
     *
     * @param mixed $model
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($service, array $data)
    {
        $request = collect($data);

        $serviceData = $request->except([...$this->inputs, ...$this->files, 'cover' , "images"])->toArray();

        $serviceSetting = $request->only($this->inputs)->toArray();

        foreach ($serviceSetting as $key => $value) {
            Settings::set($key, $value);
        }

        foreach ($this->files as $file) {
            if (isset($data[$file])) {
                Settings::instance($file)->clearMediaCollection($file);
                Settings::instance($file)->addMediaFromRequest($file)->toMediaCollection($file);
            }
        }


        if (isset($request['cover'])) {
            $service->clearMediaCollection('covers');
            $service->addMediaFromRequest('cover')->toMediaCollection('covers');
        }

        if (isset($request['images'])) {
            foreach ($request['images'] as $image) {
                $service->addMedia($image)->toMediaCollection('images');
            }
        }

        $service->update($serviceData);

        return $service;
    }

    /**
     * Delete the given Service from storage.
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
