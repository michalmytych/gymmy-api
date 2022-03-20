<?php

namespace App\Models\Training;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exercise extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'realization_id',
        'description',
        'name'
    ];

    public function muscleGroups(): BelongsToMany
    {
        return $this->belongsToMany(MuscleGroup::class);
    }

    public function series(): HasMany
    {
        return $this->hasMany(Series::class);
    }

    public function realization(): BelongsTo
    {
        return $this->belongsTo(Realization::class);
    }
}
