<?php

namespace App\Services\Training\Realization;

use App\Models\Training\Training;
use Illuminate\Database\Eloquent\Model;
use App\Models\Training\Realization\Realization;

class SeriesService
{
    public function storeOnRealization(Realization $realization, array $data): Model
    {
        if ($realization->realizationable_type === get_class(new Training)) {
            abort(422, 'training.realization.cannot-add-series-to-training-realization');
        }

        return $realization
            ->series()
            ->create($data);
    }
}