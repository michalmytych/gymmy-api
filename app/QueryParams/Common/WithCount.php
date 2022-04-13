<?php

namespace App\QueryParams\Common;

use App\QueryParams\QueryParam;
use Illuminate\Database\Eloquent\Builder;

class WithCount extends QueryParam
{
    protected function isApplicable(): bool
    {
        return request()->filled('with_count');
    }

    protected function applyParam(Builder $builder): Builder
    {
        return $builder->withCount(request()->input('with_count'));
    }
}