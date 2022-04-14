<?php

namespace App\Services\Training\Exercise;

use Illuminate\Support\Facades\Auth;
use App\Models\Training\Exercise\Exercise;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ExerciseService
{
    public function all(): LengthAwarePaginator|Collection
    {
        return Auth::user()->exercises()->withQueryParams()->paginateOrGet();
    }

    public function find(Exercise $exercise): Exercise
    {
        return $exercise;
    }

    public function create(array $data): Exercise
    {
        $exercise = Auth::user()
            ->exercises()
            ->create($data);

        $exercise
            ->muscleGroups()
            ->sync(data_get($data, 'muscle_groups_ids'));

        return $exercise->load('muscleGroups');
    }

    public function update(Exercise $exercise, array $data): Exercise
    {
        $exercise = tap($exercise)->update($data);

        $exercise
            ->muscleGroups()
            ->sync(data_get($data, 'muscle_groups_ids'));

        return $exercise->load('muscleGroups');
    }

    public function delete(Exercise $exercise)
    {
        $exercise->delete();
    }
}