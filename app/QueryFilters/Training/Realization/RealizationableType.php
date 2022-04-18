<?php

namespace App\QueryFilters\Training\Realization;

use App\QueryFilters\QueryFilter;
use App\Models\Training\Training;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Training\Exercise\Exercise;

class RealizationableType extends QueryFilter
{
    protected function applyFilter(Builder $builder): Builder
    {
        $morphAlias = match ($this->filterName()) {
            'exercise' => get_class(new Exercise),
            'training' => get_class(new Training),
        };

        return $builder->where($this->filterName(), $morphAlias);
    }
}
