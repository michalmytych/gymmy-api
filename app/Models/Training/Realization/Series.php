<?php

namespace App\Models\Training\Realization;

use App\Traits\Models\HasUuid;
use App\Traits\Models\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\QuerySorters\Common\CreatedAt as CreatedAtQuerySorter;

class Series extends Model
{
    use HasFactory, HasUuid, Sortable;

    protected $fillable = [
        'repetitions_count',
        'realization_id',
        'weight_kg'
    ];

    protected static function querySorters(): array
    {
        return [
            CreatedAtQuerySorter::class
        ];
    }

    public function realization(): BelongsTo
    {
        return $this->belongsTo(Realization::class);
    }
}
