<?php

namespace Modules\FAQs\Http\Filters;

use App\Http\Filters\BaseFilters;

class FAQFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'question',
        'answer',
    ];

    /**
     * Filter the query by a given question.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function question($value)
    {
        if ($value) {
            return $this->builder->whereTranslationLike('question', "%$value%");
        }

        return $this->builder;
    }

    /**
     * Filter the query by a given answer.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function answer($value)
    {
        if ($value) {
            return $this->builder->whereTranslationLike('answer', "%$value%");
        }

        return $this->builder;
    }


}
