<?php

namespace App\QuerySorters\Training\Realization;

use App\QuerySorters\QuerySorter;
use Illuminate\Database\Eloquent\Builder;

class TimeEnded extends QuerySorter
{
    protected function applySorter(Builder $builder): Builder
    {
        return $builder->orderBy($this->sorterName(), $this->sorterValue());
    }
}
