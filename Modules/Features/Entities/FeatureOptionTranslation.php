<?php

namespace Modules\Features\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeatureOptionTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    protected $table = 'feature_option_translations';

    public $timestamps = false;
}
