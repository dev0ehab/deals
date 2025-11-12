<?php

namespace Modules\Support\Traits;

use Modules\Favorites\Entities\Favorite;

trait Favorable
{
    protected static function bootFavorable()
    {
        static::deleting(function ($model) {
            $model->favorites->each->delete();
        });
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorite');
    }

    /**
     * Create or update a rate to model.
     *
     */
    public function favorite()
    {
        $favorite = $this->favorites()->where(['favorite_id' => request('product_id')])->first();

        if ($favorite) {
            return;
        }

        $this->favorites()->create(['user_id' => auth()->user()->id]);
        return true;
    }

    /**
     * Remove favorite from a model.
     *
     */
    public function removeFavorite()
    {
        $attributes = ['user_id' => auth()->id()];

        $this->favorites()->where($attributes)->get()->each->delete();

        return $this->favorites();
    }

    /**
     * Check if model is favored from authenticated user.
     *
     */
    public function getIsFavoredAttribute(): bool
    {
        $favorite = $this->favorites()
            ->where('favorite_id', $this->id)
            ->where("user_id", user() ? user()->id : null)
            ->where('favorite_type', get_class($this))
            ->first();

        return $favorite != null;
    }

    public function getFavorites()
    {
        return Favorite::where('user_id', $this->id)->with('favorite')->latest()->get();
    }
}
