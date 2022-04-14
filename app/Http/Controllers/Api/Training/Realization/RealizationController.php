<?php

namespace App\Http\Controllers\Api\Training\Realization;

use Illuminate\Http\JsonResponse;
use App\Models\Training\Training;
use App\Http\Controllers\Controller;
use App\Models\Training\Exercise\Exercise;
use App\Models\Training\Realization\Realization;
use App\Services\Training\Realization\RealizationService;

class RealizationController extends Controller
{
    public function __construct(private RealizationService $realizationService) {}

    public function all(): JsonResponse
    {
        return response()->paginate(
            $this->realizationService->all()
        );
    }

    public function complete(Realization $realization): JsonResponse
    {
        return response()->json(
            $this->realizationService->complete($realization)
        );
    }

    public function cancel(Realization $realization): JsonResponse
    {
        return response()->json(
            $this->realizationService->cancel($realization)
        );
    }

    public function realizeTraining(Training $training): JsonResponse
    {
        return response()->json(
            $this->realizationService->realizeTraining($training)
        );
    }

    public function realizeExercise(Exercise $exercise, Realization $parentRealization): JsonResponse
    {
        return response()->json(
            $this->realizationService->realizeExercise(
                $exercise,
                $parentRealization
            )
        );
    }
}
