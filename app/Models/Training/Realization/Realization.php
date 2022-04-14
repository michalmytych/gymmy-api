<?php

namespace App\Models\Training\Realization;

use Carbon\Carbon;
use App\Traits\Models\HasUuid;
use App\Traits\Models\Filterable;
use App\Enums\RealizationStatusType;
use App\Traits\Models\HasQueryParams;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\QueryParams\Common\Relations as RelationsQueryParam;
use App\QueryParams\Common\WithCount as WithCountQueryParam;

/**
 * @property string $id
 * @property RealizationStatusType $status
 * @property Carbon $time_started
 * @property Carbon $time_ended
 * @property string $realizationable_type
 */
class Realization extends Model
{
    use HasFactory, HasUuid, Filterable, HasQueryParams;

    protected $fillable = [
        'parent_realization_id',
        'time_started',
        'time_ended',
        'status',
    ];

    protected $casts = [
        'status' => RealizationStatusType::class,
    ];

    protected static function queryFilters(): array
    {
        return [
            /**
             * @todo
             * RealizationableNameLike
             * Realizationable
             * RealizedDateFrom
             * RealizedDateTo
             * RealizationableType
             * ParentRealization
             * Status
             * Common/FullTextSearch
             */
        ];
    }

    protected static function queryParams(): array
    {
        return [
            RelationsQueryParam::class,
            WithCountQueryParam::class
        ];
    }

    public function realizationable(): MorphTo
    {
        return $this->morphTo();
    }

    public function series(): HasMany
    {
        return $this->hasMany(Series::class);
    }

    public function parentRealization(): BelongsTo
    {
        return $this->belongsTo(Realization::class);
    }

    public function childrenRealizations(): HasMany
    {
        return $this->hasMany(Realization::class);
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

    public function cancel(): bool
    {
        return $this->update([
            'status'     => RealizationStatusType::CANCELED,
            'time_ended' => now(),
        ]);
    }
}
