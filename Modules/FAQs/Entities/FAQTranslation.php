<?php

namespace Modules\FAQs\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FAQTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['question', 'answer'];

    protected $table = 'f_a_q_translations';

    public $timestamps = false;


}
