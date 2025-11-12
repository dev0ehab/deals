<?php

namespace Modules\Support\Traits;

use Modules\Followers\Entities\Follower;

trait Followable
{
    protected static function bootFollowable()
    {
        static::deleting(function ($model) {
            $model->followers->each->delete();
        });
    }

    public function followers()
    {
        return $this->morphMany(Follower::class, 'follower');
    }

    /**
     * Create or update a rate to model.
     *
     */
    public function follower()
    {
        $follower = $this->followers()->where(['follower_id' => request('vendor_id')])->first();

        if ($follower) {
            return;
        }

        $this->followers()->create(['user_id' => auth()->user()->id]);
        return true;
    }

    /**
     * Remove follower from a model.
     *
     */
    public function removeFollower()
    {
        $attributes = ['user_id' => auth()->id()];

        $this->followers()->where($attributes)->get()->each->delete();

        return $this->followers();
    }

    /**
     * Check if model is favored from authenticated user.
     *
     */
    public function getIsFollowedAttribute(): bool
    {
        $follower = $this->followers()
            ->where('follower_id', $this->id)
            ->where('user_id', auth()->id())
            ->where('follower_type', get_class($this))
            ->first();

        return $follower != null;
    }

    public function getFollowers()
    {
        return Follower::where('user_id', $this->id)->with('follower')->latest()->get();
    }
}
