<?php

namespace Modules\Areas\Entities;

use App\Casts\JsonArrayCast;
use App\Http\Filters\Filterable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use  Translatable , Filterable;

    protected $fillable = [
        'waypoints',
        'price',
        'created_at',
        'updated_at'
    ];

    protected $table = 'areas';

    public $translatedAttributes = ['name'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'translations',
    ];

    protected $casts = [
        'waypoints' => JsonArrayCast::class
    ];
}
