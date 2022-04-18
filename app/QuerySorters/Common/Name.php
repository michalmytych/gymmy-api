<?php

namespace App\QuerySorters\Common;

use App\QuerySorters\QuerySorter;
use Illuminate\Database\Eloquent\Builder;

class Name extends QuerySorter
{
    protected function applySorter(Builder $builder): Builder
    {
        return $builder->orderBy($this->sorterName(), $this->sorterValue());
    }
}
