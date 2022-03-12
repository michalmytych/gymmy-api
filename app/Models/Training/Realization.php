<?php

namespace App\Models\Training;

use App\Enums\RealizationStatusType;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Realization extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'time_started',
        'training_id',
        'time_ended',
        'status'
    ];

    protected $casts = [
        'status' => RealizationStatusType::class
    ];

    public function series(): HasMany
    {
        return $this->hasMany(Series::class);
    }

    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class);
    }

    public function exercises(): BelongsToMany
    {
        return $this->belongsToMany(Exercise::class);
    }

    public function scopeOfStatus(Builder $builder, int $type): Builder
    {
        return $builder->where('status', $type);
    }

    public function complete(): bool
    {
        return $this->update(['status' => RealizationStatusType::COMPLETED]);
    }
}
