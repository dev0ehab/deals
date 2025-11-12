<?php

namespace Modules\Advertisements\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdvertisementTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    protected $table = 'advertisement_translations';

    public $timestamps = false;

}
