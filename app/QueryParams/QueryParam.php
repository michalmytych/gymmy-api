<?php

namespace App\QueryParams;

use Closure;
use Illuminate\Database\Eloquent\Builder;

abstract class QueryParam
{
    public function handle(Builder $builder, Closure $next): mixed
    {
        if (!$this->isApplicable()) {
            return $next($builder);
        }

        return $this->applyParam($next($builder));
    }

    abstract protected function isApplicable(): bool;

    abstract protected function applyParam(Builder $builder): Builder;
}
