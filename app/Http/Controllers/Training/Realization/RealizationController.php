<?php

namespace App\Http\Controllers\Training\Realization;

use Illuminate\View\View;
use App\Models\Training\Training;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Models\Training\Exercise\Exercise;
use App\Models\Training\Realization\Realization;

class RealizationController extends Controller
{
    public function index(): View
    {
        return view('realization.index', [
            'realizations' => Realization::where(
                'realizationable_type',
                get_class(new Training)
            )
            ->with([
                'realizationable',
                'childrenRealizations',
                'childrenRealizations.realizationable'
            ])->get()
        ]);
    }

    public function complete(Realization $realization): RedirectResponse
    {
        $realization->complete();

        if ($realization->realizationable instanceof Exercise) {
            return redirect()->to(route('training.realize', [
                'training' => $realization->parentRealization->realizationable,
            ]));
        }

        return redirect()->to(route('training.index'));
    }
}
