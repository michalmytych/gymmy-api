<?php

namespace App\Models\Training\Exercise;

use App\Traits\Models\HasUuid;
use Illuminate\Database\Eloquent\Model;
use App\Models\Training\Realization\Realization;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exercise extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'break_duration_s',
        'description',
        'name'
    ];

    public function muscleGroups(): BelongsToMany
    {
        return $this->belongsToMany(MuscleGroup::class);
    }

    public function realizations(): MorphMany
    {
        return $this->morphMany(Realization::class, 'realizationable');
    }
}
