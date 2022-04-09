<?php

namespace App\Services\Training\Realization;

use App\Models\Training\Training;
use App\Enums\RealizationStatusType;
use Illuminate\Database\Eloquent\Model;
use App\Models\Training\Exercise\Exercise;
use Illuminate\Database\Eloquent\Collection;
use App\Events\Realization\RealizationStarted;
use App\Events\Realization\RealizationCompleted;
use App\Models\Training\Realization\Realization;

class RealizationService
{
    public function all(): Collection
    {
        return Realization::query()->paginateOrGet();
    }

    public function complete(Realization $realization): Realization
    {
        if ($realization->status->isNotCompleted()) {
            $realization->complete();

            RealizationCompleted::dispatch($realization);

            return $realization;
        }

        abort(400, 'realization.already-completed');
    }

    public function realizeTraining(Training $training): Model
    {
        if ($this->isRunningRealizationOfType($training)) {
            abort(400, 'training.realization.already-running');
        }

        $realization = $training
            ->realizations()
            ->create([
                'time_started' => now(),
                'status'       => RealizationStatusType::RUNNING,
            ]);

        RealizationStarted::dispatch($realization);

        return $realization;
    }

    public function realizeExercise(Exercise $exercise, Realization $parentRealization): Model
    {
        if ($this->isRunningRealizationOfType($exercise)) {
            abort(400, 'training.realization.already-running');
        }

        if (!$parentRealization->status->isRunning()) {
            abort(400, 'training.realization.parent-realization-not-running');
        }

        $realization = $exercise
            ->realizations()
            ->create([
                'time_started'          => now(),
                'status'                => RealizationStatusType::RUNNING,
                'parent_realization_id' => $parentRealization->id,
            ]);

        RealizationStarted::dispatch($realization);

        return $realization;
    }

    private function isRunningRealizationOfType(Training|Exercise $model): bool
    {
        return Realization::query()
            ->where('status', RealizationStatusType::RUNNING)
            ->where('realizationable_type', get_class($model))
            ->exists();
    }
}