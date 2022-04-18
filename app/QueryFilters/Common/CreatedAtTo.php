<?php

namespace App\QueryFilters\Common;

use Carbon\Carbon;
use App\QueryFilters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class CreatedAtTo extends QueryFilter
{
    protected function applyFilter(Builder $builder): Builder
    {
        if (request()->has('filters.created_at_from')) {
            return $builder;
        }

        $dateTo = Carbon::parse($this->filterValue());

        return $builder->where('created_at', '<=', $dateTo);
    }
}
