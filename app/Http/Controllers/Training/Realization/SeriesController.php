<?php

namespace App\Http\Controllers\Training\Realization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Models\Training\Realization\Realization;

class SeriesController extends Controller
{
    public function store(Request $request, Realization $realization): RedirectResponse
    {
        $realization
            ->series()
            ->create($request->all());

        return redirect()->to(route('exercise.realize', [
            // @todo - wystarczy przekaza realization
            'realization'          => $realization->parentRealization->id,
            'exercise'             => $realization->realizationable,
            'exercise_realization' => $realization,
        ]));
    }
}
