<?php


namespace Modules\Vendors\Entities\Scopes;


trait VendorScopes
{


    public function scopeAccepted($query)
    {
        return $query->where('is_accepted', true);
    }

    public function scopeNeedCompletion($query)
    {
        return $query->where('is_accepted', null);
    }

    public function scopeRejected($query)
    {
        return $query->where('is_accepted', false);
    }
}
