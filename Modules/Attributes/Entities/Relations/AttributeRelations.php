<?php


namespace Modules\Attributes\Entities\Relations;


use Modules\Attributes\Entities\AttributeOption;
use Modules\Attributes\Entities\Category;

trait AttributeRelations
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(AttributeOption::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

}
