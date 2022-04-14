<?php

namespace App\Services\Training\Realization;

use Illuminate\Database\Eloquent\Model;
use App\Models\Training\Realization\Realization;

class SeriesService
{
    public function storeOnRealization(Realization $realization, array $data): Model
    {
        if ($realization->isTrainingRealization()) {
            abort(400, 'training.realization.cannot-add-series-to-training-realization');
        }

        if (!$realization->status->isRunning()) {
            abort(400, 'training.realization.cannot-add-series-to-finished-realization');
        }

        return $realization
            ->series()
            ->create($data);
    }
}