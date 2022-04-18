<?php

namespace App\Models\Training\Exercise;

use App\Traits\Models\HasUuid;
use App\Traits\Models\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\QuerySorters\Common\Name as NameQuerySorter;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MuscleGroup extends Model
{
    use HasFactory,
        HasUuid,
        Sortable;

    protected $fillable = [
        'name',
        'description'
    ];

    protected static function querySorters(): array
    {
        return [
            NameQuerySorter::class
        ];
    }
}
