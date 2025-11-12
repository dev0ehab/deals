<?php

namespace Modules\RestrictedAreas\Entities;

use App\Casts\JsonArrayCast;
use App\Http\Filters\Filterable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class RestrictedArea extends Model
{
    use  Translatable , Filterable;

    protected $fillable = [
        'waypoints',
        'created_at',
        'updated_at'
    ];

    protected $table = 'restricted_areas';

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
