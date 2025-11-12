<?php

namespace Modules\FAQs\Entities;

use App\Http\Filters\Filterable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FAQ extends Model
{
    use HasFactory, Translatable, Filterable;

    protected $fillable = ['created_at', 'updated_at'];

    protected $table = 'f_a_qs';

    public $translatedAttributes = ['question', 'answer'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'translations',
    ];

}
