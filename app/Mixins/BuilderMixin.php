<?php

namespace App\Mixins;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BuilderMixin
{
    public function paginateOrGet(): Closure
    {
        return function (): LengthAwarePaginator|Collection {
            $paginated = request()->boolean('paginated');
            $perPage   = request()->input('per_page', 15);

            /** @var Builder $this */
            return $this->when(
                $paginated,
                fn(Builder $builder) => $builder->paginate($perPage),
                fn(Builder $builder) => $builder->get()
            );
        };
    }
}