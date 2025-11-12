<?php

namespace Modules\Attributes\Entities;

use App\Http\Filters\Filterable;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\Support\Traits\Selectable;

class Category extends Model implements HasMedia
{
    use Filterable, Selectable, HasFactory, InteractsWithMedia, Translatable;

    public $translatedAttributes = ['name'];

    /**
     * @var string[]
     */
    protected $fillable = [
        'is_active',
        'rank',
    ];

    protected $with = ['translations' ,'media'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('icons')->singleFile();
    }


    public function getIconAttribute()
    {
        return $this->getFirstMediaUrl('icons');
    }

    /**
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'rank'      => 'integer',
    ];

    /**
     * Get the attributes that belong to this category.
     */
    public function attributes()
    {
        return $this->hasMany(Attribute::class, 'category_id');
    }

    /**
     * Check if the category is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->is_active;
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order by rank.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('rank');
    }
}
