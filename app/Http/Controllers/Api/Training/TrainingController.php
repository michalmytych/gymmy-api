<?php

namespace App\Http\Controllers\Api\Training;

use App\Models\Training\Training;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\Training\TrainingService;
use App\Http\Requests\Api\Training\CreateRequest;
use App\Http\Requests\Api\Training\UpdateRequest;

class TrainingController extends Controller
{
    public function __construct(private TrainingService $trainingService) { }

    public function all(): JsonResponse
    {
        return response()->paginate(
            $this->trainingService->all()
        );
    }

    public function find(Training $training): JsonResponse
    {
        return response()->json(
            $this->trainingService->find($training)
        );
    }

    public function create(CreateRequest $request): JsonResponse
    {
        return response()->json(
            $this->trainingService->create($request->validated()),
            201
        );
    }

    public function update(UpdateRequest $request, Training $training): JsonResponse
    {
        return response()->json(
            $this->trainingService->update($training, $request->validated())
        );
    }
}
