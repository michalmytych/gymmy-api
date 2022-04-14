<?php

namespace App\Jobs\Training\Realization;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Training\Realization\Realization;
use App\Services\Training\Realization\RealizationService;
use App\Events\Training\Realization\RealizationAutoTerminated;

class TerminateRealization implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private RealizationService $realizationService) {}

    public function handle(Realization $realization)
    {
        RealizationAutoTerminated::dispatch(
            $this->realizationService->complete($realization)
        );
    }
}
