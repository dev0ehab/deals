<?php

namespace Modules\Sections\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SectionTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $table = 'section_translations';

    public $timestamps = false;


}
