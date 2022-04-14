<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Training\TrainingController;
use App\Http\Controllers\Api\Training\Exercise\ExerciseController;
use App\Http\Controllers\Api\Training\Realization\SeriesController;
use App\Http\Controllers\Api\Training\Exercise\MuscleGroupController;
use App\Http\Controllers\Api\Training\Realization\RealizationController;

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
        Route::delete('/{exercise}', [ExerciseController::class, 'delete'])->name('delete');
    });

    Route::prefix('realizations')->as('realization.')->group(function () {
        Route::prefix('series')->as('series.')->group(function () {
            Route::post('/{realization}', [SeriesController::class, 'storeOnRealization'])->name('store-on-realization');
        });

        Route::get('/', [RealizationController::class, 'all'])
            ->name('all');
        Route::post('/{realization}/complete', [RealizationController::class, 'complete'])
            ->name('complete');
        Route::post('/{realization}/cancel', [RealizationController::class, 'cancel'])
            ->name('cancel');
        Route::post('/realize-training/{training}', [RealizationController::class, 'realizeTraining'])
            ->name('realize-training');
        Route::post(
            '/realize-exercise/{exercise}/realization/{parent_realization}',
            [RealizationController::class, 'realizeExercise']
        )
            ->name('realize-exercise');
    });

    Route::get('/', [TrainingController::class, 'all'])->name('all');
    Route::get('/{training}', [TrainingController::class, 'find'])->name('find');
    Route::post('/', [TrainingController::class, 'create'])->name('create');
    Route::patch('/{training}', [TrainingController::class, 'update'])->name('update');
    Route::delete('/{training}', [TrainingController::class, 'delete'])->name('delete');
});
