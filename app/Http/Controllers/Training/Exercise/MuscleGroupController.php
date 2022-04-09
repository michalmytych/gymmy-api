<?php

namespace App\Http\Controllers\Training\Exercise;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Training\Exercise\MuscleGroupService;

class MuscleGroupController extends Controller
{
    public function __construct(private MuscleGroupService $muscleGroupService) {}

    public function all(): JsonResponse
    {
        return response()->paginate(
            $this->muscleGroupService->all()
        );
    }
}
