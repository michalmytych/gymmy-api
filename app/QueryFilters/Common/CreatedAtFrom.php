<?php

namespace App\QueryFilters\Common;

use Carbon\Carbon;
use App\QueryFilters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class CreatedAtFrom extends QueryFilter
{
    protected function applyFilter(Builder $builder): Builder
    {
        $fromDate = Carbon::parse($this->filterValue());

        if (request()->has('filters.created_at_to')) {
            $toDate = Carbon::parse(request()->input('filters.created_at_to'));

            return $builder->whereBetween('created_at', [$fromDate, $toDate]);
        }

        return $builder->where('created_at', '>=', $fromDate);
    }
}
