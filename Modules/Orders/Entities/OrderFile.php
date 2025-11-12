<?php

namespace Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Orders\Entities\Relations\OrderFileRelations;
use Modules\Support\Traits\MediaTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class OrderFile extends Model implements HasMedia
{
    use OrderFileRelations, InteractsWithMedia, MediaTrait;

    /**
     * @var string[]
     */
    protected $fillable = [
        'order_id',
        'copies',
        'paper_price',
        'sub_total',
        'addons',
        'total',
        'real_paper_count',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('files');
    }

    public function getFileAttribute()
    {
        return $this->getMediaResource('files')[0] ?? null;
    }

}
