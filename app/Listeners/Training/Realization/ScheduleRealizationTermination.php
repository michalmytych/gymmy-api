<?php

namespace App\Listeners\Training\Realization;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Realization\RealizationStarted;
use App\Jobs\Training\Realization\TerminateRealization;

class ScheduleRealizationTermination implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(RealizationStarted $event)
    {
        $realization = $event->realization;

        $jobDelay = 3600;

        if ($realization->isTrainingRealization()) {
            $jobDelay = config('gymmy.training.terminate_after_s');
        }

        if ($realization->isExerciseRealization()) {
            $jobDelay = config('gymmy.exercise.terminate_after_s');
        }

        TerminateRealization::dispatch($realization)->delay(now()->addSeconds($jobDelay));
    }
}
