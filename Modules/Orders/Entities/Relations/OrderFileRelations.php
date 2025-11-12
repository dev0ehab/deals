<?php

namespace Modules\Orders\Entities\Relations;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Orders\Entities\FileAttribute;
use Modules\Orders\Entities\Order;

trait OrderFileRelations
{
    /**
     * Get the order that owns the file
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the file attributes for the file
     *
     * @return HasMany
     */
    public function fileAttributes(): HasMany
    {
        return $this->hasMany(FileAttribute::class);
    }
}
