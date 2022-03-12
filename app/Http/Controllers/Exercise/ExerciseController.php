<?php

namespace App\Http\Controllers\Exercise;

use Illuminate\Http\Request;
use App\Models\Training\Series;
use App\Models\Training\Exercise;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class ExerciseController extends Controller
{
    public function index(): View
    {
        return view('exercise.index', [
            'exercises' => Exercise::latest()->get()
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Exercise::create($request->input());

        return redirect()->to(route('exercise.index'));
    }
}
