<?php

namespace App\Services\Training\Exercise;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Training\Exercise\MuscleGroup;
use Illuminate\Pagination\LengthAwarePaginator;

class MuscleGroupService
{
    public function all(): LengthAwarePaginator|Collection
    {
        return MuscleGroup::query()->paginateOrGet();
    }
}