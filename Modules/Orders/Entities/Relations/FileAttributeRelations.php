<?php

namespace Modules\Orders\Entities\Relations;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Attributes\Entities\Attribute;
use Modules\Attributes\Entities\AttributeOption;
use Modules\Orders\Entities\OrderFile;

trait FileAttributeRelations
{
    /**
     * Get the order that owns the file
     *
     * @return BelongsTo
     */
    public function orderFile(): BelongsTo
    {
        return $this->belongsTo(OrderFile::class);
    }

    /**
     * Get the file attributes for the file
     *
     * @return BelongsTo
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    /**
     * Get the attribute option that owns the file attribute
     *
     * @return BelongsTo
     */
    public function attributeOption(): BelongsTo
    {
        return $this->belongsTo(AttributeOption::class);
    }

    /**
     * Get the option name that owns the file attribute
     *
     * @return string
     */
    public function getOptionNameAttribute()
    {
        return $this->attributeOption?->name ?? "asdasd";
    }
}
