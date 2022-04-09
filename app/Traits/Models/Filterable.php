<?php

namespace App\Traits\Models;

use Illuminate\Pipeline\Pipeline;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public static function scopeWithFilters(Builder $query): Builder
    {
        return app(Pipeline::class)
            ->send($query)
            ->through(self::queryFilters())
            ->thenReturn();
    }

    abstract protected static function queryFilters(): array;
}
