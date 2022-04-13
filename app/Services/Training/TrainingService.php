<?php

namespace App\Services\Training;

use App\Models\Training\Training;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TrainingService
{
    public function all(): LengthAwarePaginator|Collection
    {
        return Training::query()->withQueryParams()->paginateOrGet();
    }

    public function find(Training $training): Training
    {
        return $training;
    }

    public function create(array $data): Training
    {
        $training = Training::create($data);

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
}