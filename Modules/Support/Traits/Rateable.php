<?php

namespace Modules\Support\Traits;

use Modules\Vendors\Entities\Rate;

trait Rateable
{
    protected static function bootRateable()
    {
        static::deleting(function ($model) {
            $model->rates()->delete();
        });
    }

    public function rates()
    {
        return $this->morphMany(Rate::class, 'rateable');
    }

    public function rate(int $value, ?string $comment = null)
    {
        $rate = $this->rates()
            ->where('user_id', auth()->id())
            ->first();

        if ($rate) {
            $rate->update([
                'value' => $value,
                'comment' => $comment,
            ]);
        } else {
            $this->rates()->create([
                'user_id' => auth()->id(),
                'value' => $value,
                'comment' => $comment,
            ]);
        }

        $this->updateAverageRating();
    }

    public function removeRate()
    {
        $this->rates()->where('user_id', auth()->id())->delete();
        $this->updateAverageRating();
    }

    public function getIsRatedAttribute(): bool
    {
        return $this->rates()
            ->where('user_id', auth()->id())
            ->exists();
    }

    protected function updateAverageRating()
    {
        $averageRating = round($this->rates()->avg('value'), 2);
        $this->update(['rate' => $averageRating]);
    }
}

