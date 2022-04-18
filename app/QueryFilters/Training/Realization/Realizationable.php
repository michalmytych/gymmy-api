<?php

namespace App\QueryFilters\Training\Realization;

use App\QueryFilters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class Realizationable extends QueryFilter
{
    protected function applyFilter(Builder $builder): Builder
    {
        return $builder->where($this->filterRelationName(), $this->filterValue());
    }
}
