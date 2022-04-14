<?php

namespace App\Models\Training;

use App\Traits\Models\HasUuid;
use App\Traits\Models\HasQueryParams;
use Illuminate\Database\Eloquent\Model;
use App\Models\Training\Exercise\Exercise;
use App\Models\Training\Realization\Realization;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\QueryParams\Common\Relations as RelationsQueryParam;
use App\QueryParams\Common\WithCount as WithCountQueryParam;

class Training extends Model
{
    use HasFactory, HasUuid, HasQueryParams;

    protected $fillable = [
        'name',
        'user_id',
        'description'
    ];

    public function exercises(): BelongsToMany
    {
        return $this->belongsToMany(Exercise::class);
    }

    public function realizations(): MorphMany
    {
        return $this->morphMany(Realization::class, 'realizationable');
    }

    protected static function queryParams(): array
    {
        return [
            RelationsQueryParam::class,
            WithCountQueryParam::class
        ];
    }

    /**
     * @param mixed $value
     * @param string|null $field
     * @return Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return self::where($field ?: $this->getKeyName(), $value)->withQueryParams($value)->firstOrFail();
    }
}
