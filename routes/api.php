<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Training\TrainingController;
use App\Http\Controllers\Api\Training\Exercise\ExerciseController;
use App\Http\Controllers\Api\Training\Exercise\MuscleGroupController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('trainings')->as('training.')->group(function () {
    Route::prefix('exercises')->as('exercise.')->group(function () {
        Route::prefix('muscle-groups')->as('muscle-group.')->group(function () {
            Route::get('/', [MuscleGroupController::class, 'all'])->name('all');
        });

        Route::get('/', [ExerciseController::class, 'all'])->name('all');
        Route::get('/{exercise}', [ExerciseController::class, 'find'])->name('find');
        Route::post('/', [ExerciseController::class, 'create'])->name('create');
        Route::patch('/{exercise}', [ExerciseController::class, 'update'])->name('update');
    });

    Route::get('/', [TrainingController::class, 'all'])->name('all');
    Route::get('/{training}', [TrainingController::class, 'find'])->name('find');
    Route::post('/', [TrainingController::class, 'create'])->name('create');
    Route::patch('/{training}', [TrainingController::class, 'update'])->name('update');
});
