<?php

namespace Modules\Roles\Repositories;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Modules\Contracts\CrudRepository;
use Modules\Roles\Entities\Role;
use Modules\Roles\Http\Filters\RoleFilter;

class RoleRepository implements CrudRepository
{
    private $filter;

    /**
     * RoleRepository constructor.
     * @param RoleFilter $filter
     */
    public function __construct(RoleFilter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function all()
    {
        return Role::whereRoleNot(['super_admin', 'vendor', 'company', 'worker'])->filter($this->filter)->paginate(request('perPage'));
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data)
    {
        $role = Role::create($data);
        $role->attachPermissions($data['permissions']);

        return $role;
    }

    /**
     * @param mixed $model
     * @return Model|void
     */
    public function find($model)
    {
        if ($model instanceof Role) {
            return $model;
        }

        return Role::findOrFail($model);
    }

    /**
     * @param mixed $model
     * @param array $data
     * @return Model|Role|void
     */
    public function update($model, array $data)
    {
        $role = $this->find($model);

        if (!empty($role)) {
            $role->update($data);
        }
        $role->syncPermissions($data['permissions']);

        return $role;
    }

    /**
     * @param mixed $model
     * @throws Exception
     */
    public function delete($model)
    {
        $this->find($model)->delete();
    }
}
