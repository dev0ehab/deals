<?php

namespace Modules\RestrictedAreas\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RestrictedAreaTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $table = 'restricted_area_translations';

    public $timestamps = false;


}
