<?php

namespace Modules\Services\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'title', 'description'];

    protected $table = 'service_translations';

    public $timestamps = false;


}
