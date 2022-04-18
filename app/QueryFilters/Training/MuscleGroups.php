<?php

namespace App\QueryFilters\Training;

use App\QueryFilters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class MuscleGroups extends QueryFilter
{
    protected function applyFilter(Builder $builder): Builder
    {
        return $builder->whereHas('exercises.muscleGroups', fn($builder) => $builder
            ->whereIn('id', $this->filterValue())
        );
    }
}
