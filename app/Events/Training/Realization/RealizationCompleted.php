<?php

namespace App\Events\Training\Realization;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\Training\Realization\Realization;

class RealizationCompleted
{
    use Dispatchable, SerializesModels;

    public function __construct(public Realization $realization) {}
}
