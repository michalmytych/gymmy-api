<?php

namespace App\Services\Training;

use App\Models\Training\Training;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TrainingService
{
    public function all(): LengthAwarePaginator|Collection
    {
        return Auth::user()->trainings()->withQueryParams()->paginateOrGet();
    }

    public function find(Training $training): Training
    {
        return $training;
    }

    public function create(array $data): Training
    {
        $training = Auth::user()
            ->trainings()
            ->create($data);

        $training
            ->exercises()
            ->sync(data_get($data, 'exercises_ids'));

        return $training->load('exercises');
    }

    public function update(Training $training, array $data): Training
    {
        $training = tap($training)->update($data);

        $training
            ->exercises()
            ->sync(data_get($data, 'exercises_ids'));

        return $training->load('exercises');
    }

    public function delete(Training $training): void
    {
        $training->delete();
    }
}