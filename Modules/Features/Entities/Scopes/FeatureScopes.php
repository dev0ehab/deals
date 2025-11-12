<?php


namespace Modules\Features\Entities\Scopes;

trait FeatureScopes
{
    public function scopeParentFeature($query)
    {
        return $query->whereNull('parent_id')->orWhere('parent_id', 0);
    }

    public function scopeChildFeature($query)
    {
        return $query->whereNotNull('parent_id');
    }
}
