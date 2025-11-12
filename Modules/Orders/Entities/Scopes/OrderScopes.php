<?php


namespace Modules\Orders\Entities\Scopes;

use App\Enums\OrderStatusEnum;

trait OrderScopes
{
    function scopeStatusIn($query, $statues)
    {
        return $query->whereIn('status', $statues);
    }

    function scopeStatusNotIn($query, $statues)
    {
        return $query->whereNotIn('status', $statues);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('notPrePaid', function ($query) {
            $query->where('status', '!=', OrderStatusEnum::PREPAID->value);
        });
    }

}
