<?php

namespace App\Http\Controllers;

use App\Models\Training\Realization;
use Illuminate\Http\RedirectResponse;

class RealizationController extends Controller
{
    public function complete(Realization $realization): RedirectResponse
    {
        $realization->complete();

        return redirect()->to(route('training.index'));
    }
}
