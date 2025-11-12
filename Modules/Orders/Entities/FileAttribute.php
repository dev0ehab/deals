<?php

namespace Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Orders\Entities\Relations\FileAttributeRelations;

class FileAttribute extends Model
{
    use FileAttributeRelations;
    /**
     * @var string[]
     */
    protected $fillable = [
        'order_file_id',
        'attribute_id',
        'attribute_option_id',
        'option',
    ];

}
