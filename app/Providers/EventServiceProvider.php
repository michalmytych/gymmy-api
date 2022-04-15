<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use App\Events\Training\Realization\RealizationStarted;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use App\Listeners\Training\Realization\ScheduleRealizationTermination;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        RealizationStarted::class => [
            ScheduleRealizationTermination::class
        ]
    ];

    public function boot()
    {
        //
    }

    public function shouldDiscoverEvents()
    {
        return false;
    }
}
