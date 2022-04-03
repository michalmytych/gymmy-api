<?php

namespace App\Http\Controllers\Training;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Training\Training;
use App\Enums\RealizationStatusType;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Models\Training\Exercise\Exercise;
use App\Models\Training\Realization\Series;
use App\Models\Training\Realization\Realization;

class TrainingController extends Controller
{
    public function index(): View
    {
        $trainingRealization = Realization::where('realizationable_type', get_class(new Training()))
            ->ofStatus(RealizationStatusType::RUNNING)
            ->first();

        return view('training.index', [
            'trainings'   => Training::latest()->get(),
            'exercises'   => Exercise::latest()->get(),
            'realization' => $trainingRealization,
        ]);
    }

    public function show(Training $training): View
    {
        return view('training.show', [
            'training' => $training,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $training = Training::create($request->input());

        $training
            ->exercises()
            ->sync($request->input('exercises'));

        return redirect()->to(route('training.index'));
    }

    public function update(Training $training, Request $request): RedirectResponse|View
    {
        if (request()->isMethod('put')) {
            $training = tap($training)->update($request->input());

            $training
                ->exercises()
                ->sync($request->input('exercises'));

            return redirect()->to(route('training.index'));
        }

        return view('training.update', [
            'training'  => $training,
            'exercises' => Exercise::latest()->get(),
        ]);
    }

    public function realize(Training $training): View
    {
        $trainingRealization = Realization::where('realizationable_type', get_class($training))
            ->ofStatus(RealizationStatusType::RUNNING)
            ->first();

        if ($trainingRealization) {
            $passed  = $trainingRealization->updated_at->lt(now()->subHour());
            $isOther = $trainingRealization->realizationable->is($training);

            if ($passed || !$isOther) {
                $trainingRealization->complete();
            }
        } else {
            $trainingRealization = $training
                ->realizations()
                ->create([
                    'time_started' => now(),
                    'status'       => RealizationStatusType::RUNNING,
                ]);
        }

        return view('training.realize', [
            'realization' => $trainingRealization,
            'children_realizations' => $trainingRealization->childrenRealizations
        ]);
    }

    public function storeRealize(Training $training, Exercise $exercise, Request $request): RedirectResponse
    {
        $realization = Realization::ofStatus(RealizationStatusType::RUNNING)->first();

        $exercise->series()->create(array_merge(
            $request->input(),
            ['realization_id' => $realization->id]
        ));

        return redirect()->to(route('training.realize', [
            'training' => $training->id,
            'exercise' => $exercise->id,
        ]));
    }

    public function deleteSeries(Series $series): void
    {
        $series->delete();
    }
}
