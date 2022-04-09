<?php

namespace App\Models\Training\Realization;

use App\Traits\Models\HasUuid;
use App\Enums\RealizationStatusType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $id
 * @property RealizationStatusType $status
 * @property string $realizationable_type
 */
class Realization extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'parent_realization_id',
        'time_started',
        'time_ended',
        'status',
    ];

    protected $casts = [
        'status' => RealizationStatusType::class,
    ];

    public function realizationable(): MorphTo
    {
        return $this->morphTo();
    }

    public function series(): HasMany
    {
        return $this->hasMany(Series::class);
    }

    public function scopeOfStatus(Builder $builder, int $type): Builder
    {
        return $builder->where('status', $type);
    }

    public function complete(): bool
    {
        return $this->update([
            'status'     => RealizationStatusType::COMPLETED,
            'time_ended' => now(),
        ]);
    }

    public function parentRealization(): BelongsTo
    {
        return $this->belongsTo(Realization::class);
    }

    public function childrenRealizations(): HasMany
    {
        return $this->hasMany(Realization::class, 'parent_realization_id');
    }
}
