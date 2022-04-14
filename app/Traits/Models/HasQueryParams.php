<?php

namespace App\Traits\Models;

use Illuminate\Pipeline\Pipeline;
use Illuminate\Database\Eloquent\Builder;

trait HasQueryParams
{
    public static function scopeWithQueryParams(Builder $query): mixed
    {
        return app(Pipeline::class)
            ->send($query)
            ->through(self::queryParams())
            ->thenReturn();
    }

    abstract protected static function queryParams(): array;
}
