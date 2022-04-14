<?php

namespace App\Traits\Models;

use Illuminate\Pipeline\Pipeline;
use Illuminate\Database\Eloquent\Builder;

trait Sortable
{
    public static function scopeWithSorters(Builder $query): mixed
    {
        return app(Pipeline::class)
            ->send($query)
            ->through(self::querySorters())
            ->thenReturn();
    }

    abstract protected static function querySorters(): array;
}
