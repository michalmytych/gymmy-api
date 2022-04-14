<?php

namespace App\Models\Training\Exercise;

use App\Traits\Models\HasUuid;
use App\Traits\Models\Sortable;
use App\Models\Training\Training;
use App\Traits\Models\Filterable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Training\Realization\Realization;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exercise extends Model
{
    use HasFactory,
        HasUuid,
        Filterable,
        Sortable;

    protected $fillable = [
        'break_duration_s',
        'description',
        'user_id',
        'name',
    ];

    protected static function queryFilters(): array
    {
        return [
            // @todo
            // NameLike
            // Training
            // MuscleParts
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
