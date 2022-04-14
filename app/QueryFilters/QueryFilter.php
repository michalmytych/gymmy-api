<?php

namespace App\QueryFilters;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilter
{
    public function handle(Builder $builder, Closure $next): mixed
    {
        if (!request()->filled('filters.' . $this->filterName())) {
            return $next($builder);
        }

        return $this->applyFilter($next($builder));
    }

    protected function filterName(): string
    {
        return Str::snake(class_basename($this));
    }

    protected function filterRelationName(): string
    {
        return $this->filterName() . '_id';
    }

    protected function filterValue(): mixed
    {
        return request()->input('filters.' . $this->filterName());
    }

    protected function booleanFilterValue(): bool
    {
        return request()->boolean('filters.' . $this->filterName());
    }

    abstract protected function applyFilter(Builder $builder): Builder;
}
