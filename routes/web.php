<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Training\TrainingController;
use App\Http\Controllers\Training\Exercise\ExerciseController;
use App\Http\Controllers\Training\Realization\SeriesController;
use App\Http\Controllers\Training\Realization\RealizationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->to(route('training.index'));
});

Route::prefix('exercises')
    ->middleware(['auth'])
    ->as('exercise.')
    ->group(function () {
        Route::get('/', [ExerciseController::class, 'index'])->name('index');
        Route::post('/', [ExerciseController::class, 'store'])->name('store');
        Route::get('/{exercise}', [ExerciseController::class, 'show'])->name('show');
        Route::match(['get', 'put'], '/{exercise}/update', [ExerciseController::class, 'update'])
            ->name('update');
        Route::match(['get', 'post'], '/realize/{realization}', [ExerciseController::class, 'realize'])
            ->name('realize');
    });


Route::prefix('realizations')
    ->middleware(['auth'])
    ->as('realization.')
    ->group(function () {
        Route::get('/', [RealizationController::class, 'index'])->name('index');
        Route::post('/{realization}/complete', [RealizationController::class, 'complete'])->name('complete');

        Route::prefix('series')
            ->as('series.')
            ->group(function () {
                Route::post('/{realization}', [SeriesController::class, 'store'])->name('store');
            });
    });

Route::prefix('trainings')
    ->middleware(['auth'])
    ->as('training.')
    ->group(function () {
        Route::get('/', [TrainingController::class, 'index'])->name('index');
        Route::get('/{training}', [TrainingController::class, 'show'])->name('show');
        Route::match(['get', 'put'], '/{training}/update', [TrainingController::class, 'update'])->name('update');
        Route::post('/', [TrainingController::class, 'store'])->name('store');
        Route::get('/{training}/realize', [TrainingController::class, 'realize'])->name('realize');
        Route::post('/{training}/realize/{exercise}', [TrainingController::class, 'storeRealize'])->name('store-realize');

        /**
         * API
         */
        Route::delete('/series/{series}/delete', [TrainingController::class, 'deleteSeries'])->name('delete-series');
    });

require __DIR__ . '/auth.php';
