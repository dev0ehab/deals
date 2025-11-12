<?php

namespace Modules\Attributes\Entities;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{


    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }



}
