<?php

namespace Modules\Support\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

trait Selectable
{
    /**
     * Sorting the query result by the given ids.
     *
     * @param Builder $builder
     * @param mixed $ids
     * @return Builder
     */
    public function scopeSortingByIds(Builder $builder, $ids): Builder
    {
        if (is_array($ids)) {
            $case = "CASE ";
            $in = [];
            foreach ($ids as $id) {
                $case .= "WHEN id = ? THEN 0 ";
                $in[] = '?';
            }
            $in = implode(',', $in);

            $case .= "ELSE id NOT IN ($in) END";

            $builder->orderByRaw(
                $case,
                Arr::collapse([$ids, $ids])
            );
        } else {
            $builder->orderByRaw(
                "CASE WHEN id = ? THEN 0 ELSE id != ? END",
                [$ids, $ids]
            );
        }

        return $builder;
    }
}
