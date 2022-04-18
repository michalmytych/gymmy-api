<?php

namespace App\Models\Training\Exercise;

use App\Traits\Models\HasUuid;
use App\Traits\Models\Sortable;
use App\Models\Training\Training;
use App\Traits\Models\Filterable;
use App\Traits\Models\HasQueryParams;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\ResolvesWithQueryParams;
use App\Models\Training\Realization\Realization;
use App\QuerySorters\Common\Name as NameQuerySorter;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\QueryParams\Common\Relations as RelationsQueryParam;
use App\QuerySorters\Common\CreatedAt as CreatedAtQuerySorter;
use App\QueryFilters\Training\Exercise\MuscleGroups as MuscleGroupsQueryFilter;

class Exercise extends Model
{
    use HasFactory,
        HasUuid,
        Filterable,
        Sortable,
        HasQueryParams,
        ResolvesWithQueryParams;

    protected $fillable = [
        'break_duration_s',
        'description',
        'user_id',
        'name',
    ];

    protected static function queryFilters(): array
    {
        return [
            MuscleGroupsQueryFilter::class
        ];
    }

    protected static function querySorters(): array
    {
        return [
            NameQuerySorter::class,
            CreatedAtQuerySorter::class
        ];
    }

    protected static function queryParams(): array
    {
        return [
            RelationsQueryParam::class
        ];
    }

    public function trainings(): BelongsToMany
    {
        return $this->belongsToMany(Training::class);
    }

    public function muscleGroups(): BelongsToMany
    {
        return $this->belongsToMany(MuscleGroup::class);
    }

    public function realizations(): MorphMany
    {
        return $this->morphMany(Realization::class, 'realizationable');
    }
}
