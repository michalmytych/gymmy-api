<?php

namespace App\Events\Realization;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use App\Models\Training\Realization\Realization;

class RealizationCanceled
{
    use Dispatchable, SerializesModels;

    public function __construct(public Realization $realization) {}
}
