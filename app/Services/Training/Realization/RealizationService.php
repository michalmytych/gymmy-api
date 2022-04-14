<?php

namespace App\Services\Training\Realization;

use App\Models\Training\Training;
use Illuminate\Support\Facades\DB;
use App\Enums\RealizationStatusType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\Training\Exercise\Exercise;
use Illuminate\Database\Eloquent\Collection;
use App\Events\Realization\RealizationStarted;
use App\Events\Realization\RealizationCanceled;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Events\Realization\RealizationCompleted;
use App\Models\Training\Realization\Realization;

class RealizationService
{
    public function all(): Collection|LengthAwarePaginator
    {
        return Auth::user()->realizations()->paginateOrGet();
    }

    public function complete(Realization $realization): Realization
    {
        if ($realization->status->isCompleted()) {
            abort(400, 'realization.already-completed');
        }

        DB::transaction(function() use ($realization) {
            if ($realization->isTrainingRealization()) {
                $realization
                    ->childrenRealizations()
                    ->each(fn($child) => $child->complete());
            }

            $realization->complete();
        });

        RealizationCompleted::dispatch($realization);

        return $realization;
    }

    public function cancel(Realization $realization): Realization
    {
        if ($realization->status->isCompleted()) {
            abort(400, 'realization.already-completed');
        }

        if ($realization->status->isCanceled()) {
            abort(400, 'realization.already-canceled');
        }

        $realization->cancel();

        RealizationCanceled::dispatch($realization);

        return $realization;
    }

    public function realizeTraining(Training $training): Model
    {
        if ($this->isRunningRealizationOfType($training)) {
            abort(400, 'training.realization.already-running');
        }

        $realization = $training
            ->realizations()
            ->create([
                'user_id'      => Auth::id(),
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
                'user_id'               => Auth::id(),
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