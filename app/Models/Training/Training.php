<?php

namespace App\Models\Training;

use App\Traits\Models\HasUuid;
use App\Traits\Models\Sortable;
use App\Traits\Models\Filterable;
use App\Traits\Models\HasQueryParams;
use Illuminate\Database\Eloquent\Model;
use App\Models\Training\Exercise\Exercise;
use App\Traits\Models\ResolvesWithQueryParams;
use App\Models\Training\Realization\Realization;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\QueryParams\Common\Relations as RelationsQueryParam;
use App\QueryParams\Common\WithCount as WithCountQueryParam;

class Training extends Model
{
    use HasUuid,
        Sortable,
        Filterable,
        HasFactory,
        HasQueryParams,
        ResolvesWithQueryParams;

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

    protected static function queryFilters(): array
    {
        return [
            // @todo
            // NameLike
        ];
    }

    protected static function querySorters(): array
    {
        return [
            // @todo
            // LastDisplayed
            // CreatedAt
        ];
    }
}
