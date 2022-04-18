<?php

namespace App\QuerySorters;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

abstract class QuerySorter
{
    public function handle(Builder $builder, Closure $next)
    {
        if (!request()->filled('sorters.' . $this->sorterName())) {
            return $next($builder);
        }

        return $this->applySorter($next($builder));
    }

    protected function sorterName(): string
    {
        return Str::snake(class_basename($this));
    }

    protected function sorterValue()
    {
        return request()->input('sorters.' . $this->sorterName());
    }

    abstract protected function applySorter(Builder $builder): Builder;
}
