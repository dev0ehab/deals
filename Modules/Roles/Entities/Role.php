<?php

namespace Modules\Roles\Entities;

use App\Http\Filters\Filterable;
use Laratrust\Models\LaratrustRole;
use Modules\Support\Traits\Selectable;

class Role extends LaratrustRole
{
    use Filterable, Selectable;

    protected $fillable = [
        'name',
    ];

    // scopes ----------------------------
    public function scopeWhereRoleNot($query, $role_name)
    {
        return $query->whereNotIn('name', (array)$role_name);
    }

    public function scopeWhereRole($query, $role_name)
    {
        return $query->whereIn('name', (array)$role_name);
    }
}
