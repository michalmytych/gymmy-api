<?php

namespace App\Providers;

use App\Models\Training\Training;
use App\Policies\Training\TrainingPolicy;
use App\Models\Training\Exercise\Exercise;
use App\Models\Training\Realization\Series;
use App\Models\Training\Realization\Realization;
use App\Policies\Training\Exercise\ExercisePolicy;
use App\Policies\Training\Realization\SeriesPolicy;
use App\Policies\Training\Realization\RealizationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Training::class    => TrainingPolicy::class,
        Realization::class => RealizationPolicy::class,
        Exercise::class    => ExercisePolicy::class,
        Series::class      => SeriesPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
