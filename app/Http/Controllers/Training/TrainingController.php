<?php

namespace App\Http\Controllers\Training;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Training\Series;
use App\Models\Training\Training;
use App\Models\Training\Exercise;
use App\Enums\RealizationStatusType;
use App\Models\Training\Realization;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class TrainingController extends Controller
{
    public function index(): View
    {
        $realization = Realization::ofStatus(RealizationStatusType::RUNNING)->first();

        return view('training.index', [
            'trainings' => Training::latest()->get(),
            'exercises' => Exercise::latest()->get(),
            'realization' => $realization
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
        $realization = Realization::ofStatus(RealizationStatusType::RUNNING)->first();

        if ($realization) {
            $passed = $realization->updated_at->lt(now()->subHour());
            $isOther = $realization->training->is($training);

            if ($passed || !$isOther) {
                $realization->complete();
            }
        } else {
            $realization = Realization::create([
                'time_started' => now(),
                'training_id' => $training->id,
                'status' => RealizationStatusType::RUNNING
            ]);

            $realization->exercises()->saveMany($training->exercises);
        }

        return view('training.realize', [
            'realization' => $realization
                ->with(['exercises.series' => fn($builder) => $builder
                    ->where('series.realization_id', $realization->id)
                ])->first()
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
