<?php

namespace Modules\Vendors\Repositories;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Modules\Vendors\Http\Filters\VendorFilter;
use Modules\Contracts\CrudRepository;
use Modules\Vendors\Entities\Vendor;

class VendorRepository implements CrudRepository
{
    /**
     * @var VendorFilter
     */
    private $filter;

    /**
     * VendorRepository constructor.
     *
     * @param VendorFilter $filter
     */
    public function __construct(VendorFilter $filter)
    {
        $this->filter = $filter;
    }


    /**
     * Get all Vendors as a collection.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all()
    {
        return Vendor::filter($this->filter)->latest()->paginate(request('perPage'));
    }


    /**
     * Save the created model to storage.
     *
     * @param array $data
     * @return Vendor
     */
    public function create(array $data)
    {
        $vendor = Vendor::create($data);

        if (isset($data['avatar'])) {
            $vendor->addMediaFromRequest('avatar')->toMediaCollection('avatars');
        }

        return $vendor;
    }

    /**
     * Display the given Vendor instance.
     *
     * @param mixed $model
     * @return Vendor
     */
    public function find($model)
    {
        if ($model instanceof Vendor) {
            return $model;
        }

        return Vendor::findOrFail($model);
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
        $vendor = $this->find($model);

        $vendor->update($data);

        if (isset($data['avatar'])) {
            $vendor->clearMediaCollection('avatars');
            $vendor->addMediaFromRequest('avatar')->toMediaCollection('avatars');
        }

        return $vendor;
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
        $this->find($model)->delete();
    }

    /**
     * get trashed Vendors
     * @return LengthAwarePaginator
     */
    public function trashed()
    {
        return Vendor::onlyTrashed()->filter($this->filter)->paginate(request('perPage'));
    }


    /**
     * hard delete
     * @param mixed $model
     * @throws Exception
     */
    public function forceDelete($model)
    {
        $this->find($model)->forceDelete();
    }


    /**
     * restore Vendor
     * @param mixed $model
     * @throws Exception
     */
    public function restore($model)
    {
        $this->find($model)->restore();
    }


    /**
     * @param Vendor $vendor
     * @return Vendor
     */
    public function block(Vendor $vendor)
    {
        $vendor->block()->save();

        //remove device token
        $vendor->update([
            'device_token' => null
        ]);

        $vendor->tokens()->delete();

        return $vendor;
    }

    /**
     * @param Vendor $vendor
     * @return Vendor
     */
    public function unblock(Vendor $vendor)
    {
        $vendor->unblock()->save();

        return $vendor;
    }


    /**
     * Change the given vendor status.
     *
     * @param mixed $model
     * @return void
     * @throws \Exception
     */
    public function changeStatus($model)
    {
        $vendor = $this->find($model);

        $vendor->update([
            'status' => request('status')
        ]);

        return $vendor;
    }
}
