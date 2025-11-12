<?php


namespace Modules\Attributes\Entities\Relations;


use Modules\Attributes\Entities\Attribute;

trait AttributeOptionRelations
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
