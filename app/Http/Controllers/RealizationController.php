<?php

namespace App\Http\Controllers;

use App\Models\Training\Realization;

class RealizationController extends Controller
{
    public function complete(Realization $realization)
    {
        $realization->complete();

        return redirect()->to(route('training.index'));
    }
}
