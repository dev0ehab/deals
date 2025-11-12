<?php

namespace Modules\Settings\Repositories;

use Modules\Contracts\CrudRepository;
use Modules\Settings\Entities\Setting;

class SettingRepository implements CrudRepository
{
    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all()
    {
        //
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }
    }

    /**
     * @param mixed $model
     * @return \Illuminate\Database\Eloquent\Model|void
     */
    public function find($model)
    {
        //
    }

    /**
     * @param mixed $model
     * @param array $data
     */
    public function update($model, array $data)
    {
        //
    }

    /**
     * @param mixed $model
     */
    public function delete($model)
    {
        //
    }
}
