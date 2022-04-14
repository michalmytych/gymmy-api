<?php

namespace App\Mixins;

use Closure;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Model $model
 */
class FactoryMixin
{
    public function firstOrCreate(): Closure
    {
        return function (): Model {
            return $this->model::first() ?? $this->model::factory()->create();
        };
    }
}