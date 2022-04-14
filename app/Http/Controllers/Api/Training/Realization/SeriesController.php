<?php

namespace App\Http\Controllers\Api\Training\Realization;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Training\Realization\Realization;
use App\Services\Training\Realization\SeriesService;
use App\Http\Requests\Api\Training\Realization\Series\StoreRequest;

class SeriesController extends Controller
{
    public function __construct(private SeriesService $seriesService) {}

    public function storeOnRealization(StoreRequest $storeRequest, Realization $realization): JsonResponse
    {
        return response()->json(
            $this->seriesService->storeOnRealization(
                $realization,
                $storeRequest->validated()
            )
        );
    }
}
