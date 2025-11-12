<?php

namespace Modules\Advertisements\Repositories;

use Modules\Contracts\CrudRepository;
use Modules\Advertisements\Entities\Advertisement;
use Modules\Advertisements\Http\Filters\AdvertisementFilter;

class AdvertisementRepository implements CrudRepository
{
    /**
     * @var \Modules\Advertisements\Http\Filters\AdvertisementFilter
     */
    private $filter;

    /**
     * AdvertisementRepository constructor.
     *
     * @param \Modules\Advertisements\Http\Filters\AdvertisementFilter $filter
     */
    public function __construct(AdvertisementFilter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Get all Advertisements as a collection.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all()
    {
        return Advertisement::filter($this->filter)->latest()->paginate(request('perPage'));
    }

    /**
     * Save the created model to storage.
     *
     * @param array $data
     * @return \Modules\Advertisements\Entities\Advertisement
     */
    public function create(array $data)
    {
        $advertisement = Advertisement::create($data);

        $advertisement->addMediaFromRequest('image')->toMediaCollection('images');

        return $advertisement;
    }

    /**
     * Display the given Advertisement instance.
     *
     * @param mixed $model
     * @return \Modules\Advertisements\Entities\Advertisement
     */
    public function find($model)
    {
        if ($model instanceof Advertisement) {
            return $model;
        }

        return Advertisement::findOrFail($model);
    }

    /**
     * Update the given Advertisement in the storage.
     *
     * @param mixed $model
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($model, array $data)
    {
        $advertisement = $this->find($model);

        $advertisement->update($data);

        if (isset($data['image'])) {
            $advertisement->clearMediaCollection('images');
            $advertisement->addMediaFromRequest('image')->toMediaCollection('images');
        }

        return $advertisement;
    }

    /**
     * Delete the given Advertisement from storage.
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
