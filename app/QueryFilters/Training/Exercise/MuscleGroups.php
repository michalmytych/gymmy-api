<?php

namespace App\QueryFilters\Training\Exercise;

use App\QueryFilters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class MuscleGroups extends QueryFilter
{
    protected function applyFilter(Builder $builder): Builder
    {
        return $builder->whereHas('muscleGroups', fn($builder) => $builder
            ->whereIn('id', $this->filterValue())
        );
    }
}
