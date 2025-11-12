<?php

namespace Modules\Attributes\Entities;

use Illuminate\Database\Eloquent\Model;

class AttributeOptionTranslation extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
