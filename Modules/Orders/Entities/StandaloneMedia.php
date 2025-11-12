<?php

namespace Modules\Orders\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Support\Traits\MediaTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class StandaloneMedia extends Model implements HasMedia
{
    use InteractsWithMedia , MediaTrait;

    protected $table = 'standalone_media'; // optional, or just use default

    protected $fillable = [
        'created_at',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('files');
    }


    public function getFilesAttribute()
    {
        return $this->getMediaResource('files');
    }


    public static function boot()
    {
        parent::boot();

        static::deleting(function ($media) {
            $media->getMedia('files')->each(function ($file) {
                $file->model_id = null;
                $file->model_type = null;
                $file->save();
            });
        });
    }
}
