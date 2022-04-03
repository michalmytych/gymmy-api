<?php

namespace App\Http\Controllers\Training\Exercise;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Enums\RealizationStatusType;
use Illuminate\Http\RedirectResponse;
use App\Models\Training\Exercise\Exercise;
use App\Models\Training\Exercise\MuscleGroup;
use App\Models\Training\Realization\Realization;

class ExerciseController extends Controller
{
    public function index(): View
    {
        return view('exercise.index', [
            'exercises'     => Exercise::latest()->get(),
            'muscle_groups' => MuscleGroup::orderBy('name')->get(),
        ]);
    }

    public function show(Exercise $exercise): View
    {
        return view('exercise.show', [
            'exercise' => $exercise,
            'muscle_groups' => MuscleGroup::all()
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $exercise = Exercise::create($request->input());

        $exercise->muscleGroups()->sync($request->input('muscle_groups'));

        return redirect()->to(route('exercise.index'));
    }

    public function update(Exercise $exercise, Request $request): RedirectResponse|View
    {
        if (request()->isMethod('put')) {
            $training = tap($exercise)->update($request->input());

            $training
                ->muscleGroups()
                ->sync($request->input('muscle_groups'));

            return redirect()->to(route('exercise.index'));
        }

        return view('exercise.update', [
            'exercise'  => $exercise,
            'muscle_groups' => $exercise->muscleGroups,
        ]);
    }

    public function realize(Request $request, Realization $realization): View
    {
        $exercise = Exercise::findOrFail($request->input('exercise'));

        $exerciseRealization = Realization::find($request->input('exercise_realization'));

        if ($request->isMethod('POST')) {
            $exerciseRealization = $exercise
                ->realizations()
                ->create([
                    'parent_realization_id' => $realization->id,
                    'time_started'          => now(),
                    'status'                => RealizationStatusType::RUNNING,
                ]);
        }

        return view('exercise.realize', [
            'exercise'             => $exercise,
            'training_realization' => $realization,
            'realization'          => $exerciseRealization,
        ]);
    }
}
