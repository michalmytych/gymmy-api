<?php

namespace App\Http\Controllers\Exercise;

use Illuminate\Http\Request;
use App\Models\Training\Exercise;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Models\Training\MuscleGroup;
use Illuminate\Http\RedirectResponse;

class ExerciseController extends Controller
{
    public function index(): View
    {
        return view('exercise.index', [
            'exercises' => Exercise::latest()->get(),
            'muscle_groups' => MuscleGroup::orderBy('name')->get()
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $exercise = Exercise::create($request->input());

        $exercise->muscleGroups()->sync($request->input('muscle_groups'));

        return redirect()->to(route('exercise.index'));
    }
}
