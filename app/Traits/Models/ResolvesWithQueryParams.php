<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $param, mixed $value)
 * @method getKeyName()
 */
trait ResolvesWithQueryParams
{
    /**
     * @param mixed $value
     * @param string|null $field
     * @return Model|null
     * @noinspection PhpMissingReturnTypeInspection
     * @noinspection PhpMissingParamTypeInspection
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return self::where($field ?: $this->getKeyName(), $value)->withQueryParams($value)->firstOrFail();
    }
}