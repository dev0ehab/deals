<?php

namespace Modules\Roles\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Roles\Entities\Role;
use Modules\Roles\Http\Filters\SelectFilter;
use Modules\Roles\Transformers\RoleSelectResource;

class SelectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SelectFilter $filter
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function roles(SelectFilter $filter)
    {
        $roles = Role::whereRoleNot(['super_admin', 'vendor', 'company', 'worker'])->filter($filter)->paginate();

        return RoleSelectResource::collection($roles);
    }
}
