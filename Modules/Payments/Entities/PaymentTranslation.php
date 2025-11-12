<?php

namespace Modules\Payments\Entities;

use Illuminate\Database\Eloquent\Model;

class PaymentTranslation extends Model
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
