<?php

namespace Modules\Attributes\Entities;

use Illuminate\Database\Eloquent\Model;
class BulkDiscount extends Model
{

    /**
     * @var string[]
     */
    protected $fillable = [
        'from',
        'to',
        'percent',
    ];


    protected $table = 'bulk_discount_percent';

    /**
     * @var array
     */
    protected $casts = [
        'percent' => 'float',
    ];

}
