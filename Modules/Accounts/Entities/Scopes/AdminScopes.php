<?php


namespace Modules\Accounts\Entities\Scopes;


trait AdminScopes
{
// scopes ------------------------------

    public function scopeWhereRole($query, $role_name)
    {
        return $query->whereHas('roles', function ($q) use ($role_name) {
            return $q->whereIn('name', (array)$role_name);
        });
    }

    public function scopeWhereRoleNot($query, $role_name)
    {
        return $query->whereHas('roles', function ($q) use ($role_name) {
            return $q->whereNotIn('name', (array)$role_name);
        });
    }

    public function scopeVendor($query)
    {
        return $query->where('belongs_to_vendor', true);
    }

    public function scopeNotVendor($query)
    {
        return $query->where('belongs_to_vendor', false);
    }
}
