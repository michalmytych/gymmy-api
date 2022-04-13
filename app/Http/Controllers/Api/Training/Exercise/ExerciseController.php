<?php

namespace App\Http\Controllers\Api\Training\Exercise;

use JetBrains\PhpStorm\Pure;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Training\Exercise\Exercise;
use App\Services\Training\Exercise\ExerciseService;
use App\Http\Requests\Api\Training\Exercise\CreateRequest;
use App\Http\Requests\Api\Training\Exercise\UpdateRequest;

class ExerciseController extends Controller
{
    public function __construct(private ExerciseService $exerciseService) {}

    public function all(): JsonResponse
    {
        return response()->paginate(
            $this->exerciseService->all()
        );
    }

    #[Pure] public function find(Exercise $exercise): Exercise
    {
        return $this->exerciseService->find($exercise);
    }

    public function create(CreateRequest $request): Exercise
    {
        return $this->exerciseService->create($request->validated());
    }

    public function update(UpdateRequest $request, Exercise $exercise): Exercise
    {
        return $this->exerciseService->update($exercise, $request->validated());
    }

    #[Pure] public function delete(Exercise $exercise): void
    {
        $this->exerciseService->delete($exercise);
    }
}
