<?php

namespace Modules\Areas\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AreaTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $table = 'area_translations';

    public $timestamps = false;


}
